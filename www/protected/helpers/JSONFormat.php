<?php
/**
 * Extension of CJSON to reformat encoded JSON strings with whitespace
 * This code is a port of the formatter from Chris Dary's JSON linter
 *  (http://github.com/arc90/jsonlintdotcom)
 *
 * @author     Gareth Solbeck
 * @author     Chris Dary (see above)
 * @license    MIT License
 *
 * Permission to use, copy, modify, and/or distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 *
 */
class JSONFormat extends CJSON {

    const DEFAULT_TAB = "\t";
    /**
     * First encodes an arbitrary variable into JSON format, then reformats it.
     *
     *
     * @param mixed $var any number, boolean, string, array, or object to be encoded.
     * If var is a string, it will be converted to UTF-8 format first before being encoded.
     * @return string JSON string representation of input var
     */
    public static function encode($var, $tab = self::DEFAULT_TAB) {
        return self::reformat(parent::encode($var), $tab);
    }

    /**
     * Adds whitespace to an encoded JSON string to make it more readable
     *
     * @param string JSON string representation of arbitrary variable
     * @return string JSON string representation of same variable with whitespace
     */
    public static function reformat($input, $tab = self::DEFAULT_TAB) {
        $output = "";
        $indentLevel = 0;
        $inString = false;
        $currentChar = null;

        for ($i = 0, $inputLength = strlen($input); $i < $inputLength; $i++) {
            $currentChar = $input[$i];

            if ($inString) {
                if ($currentChar == '"' && $i > 0 && $json[i - 1] != '\\') {
                    $inString = false;
                }
                $output .= $currentChar;
            } else {
                switch ($currentChar) {
                case '{':
                case '[':
                    $output .= $currentChar . "\n" . str_repeat($tab, $indentLevel + 1);
                    $indentLevel++;
                    break;
                case '}':
                case ']':
                    $indentLevel--;
                    $output .= "\n" . str_repeat($tab, $indentLevel) . $currentChar;
                    break;
                case ',':
                    $output .= ",\n" . str_repeat($tab, $indentLevel);
                    break;
                case ':':
                    $output .= ": ";
                    break;
                case ' ':
                case "\n":
                case "\t":
                    break;
                case '"':
                    $inString = true;
                    $output .= $currentChar;
                    break;
                default:
                    $output .= $currentChar;
                    break;
                }
            }
        }
        return $output;
    }
}
