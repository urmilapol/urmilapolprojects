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
 * @subpackage urplastaccess
 * @copyright 2016 urmila pol
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.

 */
require_once('/../../config.php');

require_once("$CFG->libdir/formslib.php");
class urplaccess_form extends moodleform{

public function definition() {

    global $DB;
    $mform = & $this->_form;
    $options = array();
    // Get the courses pass to the form.

    $options[0] = get_string('choose');
    $options += $this->_customdata['courses'];
    $mform->addElement('select', 'course', get_string('course'), $options, 'align="center"');
    $mform->settype('course', PARAM_ALPHANUMEXT);
    $mform->addElement('date_selector', 'lastaccesseddate', get_string('from'), 'align="center"');
    $mform->settype('lastaccesseddate', PARAM_INT);
    $mform->addElement('date_selector', 'currentdate', get_string('to'), 'align="center"');
    $mform->settype('currentdate', PARAM_INT);
    $mform->addElement('submit', 'save', get_string('display', 'report_urplaccess'), 'align="right"');
}

public function validation($data, $files) {

   $errors = parent::validation($data, $files);
// Added to check whether the course option selected is valid.

if ($data['course'] == '0' ) {

    $errors['course'] = get_string('error_invalidcourse', 'report_urplaccess');
}

// Added to compare lastaccessdate and currentdate.
if ($data['lastaccesseddate'] > $data['currentdate']) {
    $errors['lastaccesseddate'] = get_string('error_invaliddate', 'report_urplaccess');
    // Added to compare currentdate to system date.
    if ($data['currentdate'] > time(date("d-m-y"))) {
        $errors['currentdate'] = get_string('error_invalidicurrentdate', 'report_urplaccess');
    }
    // Added to check the last accessed date is not equal to zero.
    if ($data['lastaccesseddate'] == 0 ) {
        $errors['lastaccesseddate'] = get_string('error_nolastaccesseddate', 'report_urplaccess');
    }

    return $errors;

}
if ($users = $DB->get_records_sql($sql, $params)) {

    $table = new html_table();
    $table->head = array($strcourse, $strname, $strlastaccess, $stragency, $strgrade);

    foreach ($users as $u) {
        if ($u->finalgrade) {
            $finalgrade = round($u->finalgrade, $CFG->grade_decimalpoints);
        } else {

            $finalgrade = 0;
        }
        // Displays the table data.

        $table->data[] = array($u->fullname, fullname($u), userdate($u->agency, $finalgrade);

    }
} else {
    echo $OUTPUT->header();
    echo $OUTPUT->heading($strtitle);
    $mform->display();

    if (!empty($table->$data)) {
            echo html_writer::table($table);
        echo $OUTPUT->single_button("index.php?export=1&cid=$data->course&cd=$data->currentdate&ld=$data-lastaccesseddate", get_stri
        ng('exportcsv', 'report_urplaccess'));
    }
    echo $OUTPUT->footer();
}
