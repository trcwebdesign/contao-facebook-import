<?php

declare(strict_types=1);

/*
 * Contao Facebook Import Bundle for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2017-2018, Moritz Vondano
 * @license    MIT
 * @link       https://github.com/m-vo/contao-facebook-import
 *
 * @author     Moritz Vondano
 */

namespace Mvo\ContaoFacebookImport\String;

class Tools
{
	/**
	 * @param string $str
	 *
	 * @return mixed
	 */
	public static function formatText(string $str)
	{
		$str = utf8_decode($str);
		$str = self::replaceUrls($str);
		return self::formatWhitespaces($str);
	}

	/**
	 * @param string $str
	 *
	 * @return mixed
	 */
	private static function replaceUrls(string $str)
	{
		// surround urls with <a> tags
		return preg_replace(
			'#(https?\://)?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(/\S*)?#',
			'<a rel="nofollow noreferrer" href="$1">$1</a>',
			$str
		);
	}

	/**
	 * @param string $str
	 *
	 * @return mixed
	 */
	private static function formatWhitespaces(string $str)
	{
		return nl2br_html5(str_replace('  ', '&nbsp;&nbsp;', $str));
	}

	/**
	 * @param string $str
	 * @param int    $maxWords
	 *
	 * @param int    $wordsOffset
	 *
	 * @return mixed
	 */
	public static function shortenText(string $str, int $maxWords, int $wordsOffset)
	{
		$words            = explode(' ', $str);
		$initialWordCount = \count($words);

		// slice it
		$words = \array_slice($words, $wordsOffset, $maxWords);

		if (0 === \count($words)) {
			return '';
		}

		// remove some characters at the end: , . -
		$words[\count($words) - 1] = str_replace([',', '.', '-'], '', $words[\count($words) - 1]);

		$str = rtrim(implode($words, ' '));
		return ($initialWordCount > \count($words)) ? sprintf('%s&hellip;', $str) : $str;
	}
}