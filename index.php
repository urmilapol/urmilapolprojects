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
 * version details.
 * @package report
 * @subpackage  urplaccess
 * @copyright  2016 urmila pol
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('/../../config.php');

require($CFG->dirrroot.'/report/urplaccess/index_form.php');


// Get the system context.
$systemcontext = get_system_context();
$url = new moodle_url('report/urplaccess/index.php');
// Check basic permission.
require_capability('report/urplaccess:view', $systemcontext);
// Get the language strings from language file.
$strtitle = get_string('title', 'report_urplaccess');
// Setup page objects.
$PAGE->set_url($url);
$PAGE->set_context($systemcontext);
$PAGE->set_title($strtitle);
$PAGE->set_pagelayout('report');
$PAGE->set_heading($strtitle);
// Get the courses.
$sql = "SELECT id,fullname FROM {course} WHERE visible = :visible AND id != :siteid order by fullname";
$courses = $DB->get_records_sql_menu($sql, array('visible' => 1, 'siteid' => SITEID));
// Load up the form.
$mform = new urplaccess_form('', array('courses' => $courses));
echo $OUTPUT->header();
echo $OUTPUT->heading($strtitle);
$mform->display();
echo $OUTPUT->footer();



