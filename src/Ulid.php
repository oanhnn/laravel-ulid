<?php

namespace Laravel\Ulid;

/**
 * Class Ulid
 *
 * @package     Laravel\Ulid
 * @author      Oanh Nguyen <oanhnn.bk@gmail.com>
 * @license     The MIT license
 */
class Ulid
{
    /**
     * @const int
     */
    const ENCODING_BASE = 32;

    /**
     * @const int
     */
    const TIME_PART_LENGTH = 10;

    /**
     * @const int
     */
    const RAND_PART_LENGTH = 16;

    /**
     * @var string
     */
    private static $encodingChars = '0123456789abcdefghjkmnpqrstvwxyz';

    /**
     * @var int
     */
    private static $lastGeneratedTime = 0;

    /**
     * @var array
     */
    private static $lastGeneratedChars = [];

    /**
     * @var string
     */
    private $time;

    /**
     * @var string
     */
    private $randomness;

    /**
     * Ulid constructor.
     *
     * @param string $time
     * @param string $randomness
     */
    private function __construct(string $time, string $randomness)
    {
        $this->time = $time;
        $this->randomness = $randomness;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getRandomness(): string
    {
        return $this->randomness;
    }

    /**
     * @return string
     */
    public function toUppercase(): string
    {
        return strtoupper($this->__toString());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->time . $this->randomness;
    }

    /**
     * @param  Ulid $other
     * @return bool
     */
    public function equals(Ulid $other): bool
    {
        return $this->__toString() === $other->__toString();
    }

    /**
     * @param string $value The ULID string
     * @return self
     */
    public static function fromString(string $value): self
    {
        return new static(
            substr($value, 0, self::TIME_PART_LENGTH),
            substr($value, self::TIME_PART_LENGTH, self::RAND_PART_LENGTH)
        );
    }

    /**
     * @return self
     * @throws \Exception
     */
    public static function generate(): self
    {
        $now = intval(microtime(true) * 1000);
        $duplicateTime = $now === static::$lastGeneratedTime;
        static::$lastGeneratedTime = $now;

        // If the timestamp hasn't changed since last push,
        // use the same random number, except incremented by random number (1 to 10).
        if ($duplicateTime && !empty(static::$lastGeneratedChars)) {
            $add = rand(1, 10);
            $out = '';
            $chars = static::$lastGeneratedChars;
            for ($i = 0; $i < static::TIME_PART_LENGTH + static::RAND_PART_LENGTH; $i++) {
                $chars[$i] += $add;
                if ($chars[$i] > 31) {
                    $chars[$i] = ($now = $chars[$i]) % static::ENCODING_BASE;
                    $add = ($now - $chars[$i]) / static::ENCODING_BASE;
                } else {
                    $add = 0;
                }

                $out = static::encodeChar($chars[$i]) . $out;
            }

            static::$lastGeneratedChars = $chars;

            return static::fromString($out);
        }

        $timeChars = '';
        $randChars = '';
        $chars = range(0, static::TIME_PART_LENGTH + static::RAND_PART_LENGTH - 1, 1);

        for ($i = static::TIME_PART_LENGTH + static::RAND_PART_LENGTH - 1; $i >= static::RAND_PART_LENGTH; $i--) {
            $chars[$i] = $now % static::ENCODING_BASE;
            $now = ($now - $chars[$i]) / static::ENCODING_BASE;
            $timeChars .= static::encodeChar($chars[$i]);
        }

        for ($i = static::RAND_PART_LENGTH - 1; $i >= 0; $i--) {
            $chars[$i] = random_int(0, 31);
            $randChars .= static::encodeChar($chars[$i]);
        }

        static::$lastGeneratedChars = $chars;

        return new static($timeChars, $randChars);
    }

    /**
     * @param int $code
     * @return string
     */
    private static function encodeChar(int $code): string
    {
        return static::$encodingChars[$code] ?? '0';
    }
}
