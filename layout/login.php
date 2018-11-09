<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * A login page layout for trema.
 *
 * @package    theme_trema
 * @copyright  2018 Trevor Furtado e Rodrigo Mady
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

// Check if the login page are using particles or image background.
$loginstyle = get_config('theme_trema', 'loginpagestyle');
$additionalclasses = [
    $loginstyle == "particle-circles" ? 'style-particles' : 'style-image'
];
$bodyattributes = $OUTPUT->body_attributes($additionalclasses);

// Only load particles.js if needed.
if ($loginstyle == "particle-circles") {
    $particlesconfig = json_decode(file_get_contents("$CFG->wwwroot/theme/trema/particles.json"));
    $particlesconfig->particles->color->value = get_config("theme_trema", "particles_circlescolor");

    $PAGE->requires->js_call_amd('theme_trema/tremaparticles', 'init', array(
        json_encode(($particlesconfig))
    ));
}

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, [
        'context' => context_course::instance(SITEID),
        "escape" => false
    ]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes
];

echo $OUTPUT->render_from_template('theme_trema/login', $templatecontext);

