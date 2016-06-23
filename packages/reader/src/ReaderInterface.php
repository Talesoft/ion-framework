<?php
declare(strict_types=1);

namespace Ion;

interface ReaderInterface
{

    public function getInput(): string;
    public function getEncoding(): string;
    public function getLastPeekResult(): string;
    public function getLastMatchResult(): array;
    public function getNextConsumeLength(): int;
    public function getPosition(): int;
    public function getLine();
    public function getOffset();
    public function normalize(): ReaderInterface;
    public function getLength(): int;
    public function hasLength(): bool;

    public function peek(int $length = null, int $start = null): string;
    public function match(string $pattern, string $modifiers = null, string $ignoredSuffixes = null): bool;
    public function getMatch($key): string;
    public function getMatchData(): array;
    public function consume(int $length = null): string;

    public function readWhile(callable $callback, int $peekLength = null): string;
    public function readUntil(callable $callback, int $peekLength = null): string;

    public function peekChar(string $char): bool;
    public function peekChars($chars): bool;
    public function peekString(string $string): bool;
    public function peekNewLine(): bool;
    public function peekIndentation(): bool;
    public function peekQuote(): bool;
    public function peekSpace(): bool;
    public function peekDigit(): bool;
    public function peekAlpha(): bool;
    public function peekAlphaNumeric(): bool;
    public function peekAlphaIdentifier($allowedChars = null): bool;
    public function peekIdentifier($allowedChars = null): bool;

    public function readIndentation(): ?string;
    public function readUntilNewLine(): ?string;
    public function readSpaces(): ?string;
    public function readDigits(): ?string;
    public function readAlpha(): ?string;
    public function readAlphaNumeric(): ?string;
    public function readIdentifier(string $prefix = null, array $allowedChars = null): ?string;
    public function readString(array $escapeSequences = null, bool $raw = false): ?string;
    public function readExpression(array $breaks = null, array $brackets = null): ?string;
}