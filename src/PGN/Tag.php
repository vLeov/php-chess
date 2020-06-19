<?php

namespace PGNChess\PGN;

/**
 * PGN tags.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license GPL
 */
class Tag
{
	// STR (Seven Tag Roster)
    const EVENT = 'Event';
	const SITE = 'Site';
	const DATE = 'Date';
	const ROUND = 'Round';
	const WHITE = 'White';
	const BLACK = 'Black';
	const RESULT = 'Result';

    // FICS database
    const FICS_GAMES_DB_GAME_NO = 'FICSGamesDBGameNo';

	// player related information
	const WHITE_TITLE = 'WhiteTitle';
	const BLACK_TITLE = 'BlackTitle';
	const WHITE_ELO = 'WhiteElo';
	const BLACK_ELO = 'BlackElo';
	const WHITE_USCF = 'WhiteUSCF';
	const BLACK_USCF = 'BlackUSCF';
	const WHITE_NA = 'WhiteNA';
	const BLACK_NA = 'BlackNA';
	const WHITE_TYPE = 'WhiteType';
	const BLACK_TYPE = 'BlackType';

	// event related information
	const EVENT_DATE = 'EventDate';
	const EVENT_SPONSOR = 'EventSponsor';
	const SECTION = 'Section';
	const STAGE = 'Stage';
	const BOARD = 'Board';

	// opening information
	const OPENING = 'Opening';
	const VARIATION = 'Variation';
	const SUB_VARIATION = 'SubVariation';
	const ECO = 'ECO';
	const NIC = 'NIC';

	// time and date related information
	const TIME = 'Time';
    const TIME_CONTROL = 'TimeControl';
	const UTC_TIME = 'UTCTime';
	const UTC_DATE = 'UTCDate';

    // clock
    const WHITE_CLOCK = 'WhiteClock';
    const BLACK_CLOCK = 'BlackClock';

	// alternative starting positions
	const SET_UP = 'SetUp';
	const FEN = 'FEN';

	// game conclusion
	const TERMINATION = 'Termination';

	// miscellaneous
	const ANNOTATOR = 'Annotator';
	const MODE = 'Mode';
	const PLY_COUNT = 'PlyCount';
    const WHITE_RD = 'WhiteRD';
    const BLACK_RD = 'BlackRD';

    public static function getConstants(): array
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * Basic tags expected to be found in a game.
     *
     * @param array $tags
     * @return bool true if the tags were found; otherwise false
     */
    public static function mandatory(array $tags): bool
    {
        return isset(
            $tags[Tag::EVENT],
            $tags[Tag::SITE],
            $tags[Tag::DATE],
            $tags[Tag::WHITE],
            $tags[Tag::BLACK],
            $tags[Tag::RESULT]
        );
    }

    public static function reset(array &$tags)
    {
        $tags = [];
        foreach (Tag::getConstants() as $key => $value) {
            $tags[$value] = null;
        }
    }
}
