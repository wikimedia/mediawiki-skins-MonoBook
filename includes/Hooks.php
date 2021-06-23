<?php
/**
 * MonoBook hooks
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

namespace MonoBook;

use OutputPage;
use Skin;
use User;

class Hooks {
	/**
	 * Add the "monobook-capitalize-all-nouns" CSS class to the <body> element for German
	 * (de) and various languages which have German set as a fallback language, such
	 * as Colognian (ksh) and others.
	 *
	 * @see https://phabricator.wikimedia.org/T97892
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/OutputPageBodyAttributes
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @param array &$bodyAttrs Pre-existing attributes for the <body> element
	 */
	public static function onOutputPageBodyAttributes( OutputPage $out, Skin $skin, &$bodyAttrs ) {
		$lang = $skin->getLanguage();
		if (
			$skin->getSkinName() === 'monobook' && (
				$lang->getCode() === 'de' ||
				in_array( 'de', $lang->getFallbackLanguages() )
			)
		) {
			$bodyAttrs['class'] .= ' monobook-capitalize-all-nouns';
		}
	}

	/**
	 * @param User $user
	 * @param array &$preferences
	 */
	public static function onGetPreferences( User $user, array &$preferences ) {
		$preferences['monobook-responsive'] = [
			'type' => 'toggle',
			'label-message' => 'monobook-responsive-label',
			'section' => 'rendering/skin/skin-prefs',
			// Only show this section when the Monobook skin is checked. The JavaScript client also uses
			// this state to determine whether to show or hide the whole section.
			'hide-if' => [ '!==', 'wpskin', 'monobook' ],
		];
	}
}
