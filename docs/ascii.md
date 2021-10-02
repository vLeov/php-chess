#### `toArray(Board $board): array`

Returns an ASCII array from a `Chess\Board`.

#### `toBoard(array $array, string $turn, $castling = null): Board`

Returns a `Chess\Board` from an ASCII array.

#### `print(Board $board): string`

Returns an ASCII string from a `Chess\Board`.

#### `fromAlgebraicToIndex(string $square): array`

Returns the ASCII array indexes of a specific square described in algebraic notation.

#### `fromIndexToAlgebraic(int $i, int $j): string`

Returns the square in algebraic notation corresponding to the specific ASCII array indexes.

#### `setArrayElem(string $piece, string $square, &$array)`

Sets a piece as an ASCII char in a square in an ASCII array.
