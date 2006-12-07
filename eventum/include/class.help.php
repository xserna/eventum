<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Eventum - Issue Tracking System                                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003, 2004, 2005 MySQL AB                              |
// |                                                                      |
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to:                           |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// | Authors: João Prado Maia <jpm@mysql.com>                             |
// +----------------------------------------------------------------------+
//
// @(#) $Id: s.class.help.php 1.16 03/12/31 17:29:00-00:00 jpradomaia $
//

require_once(APP_INC_PATH . "class.error_handler.php");

$topics = array(
    "main" => array(
        "title"  => ev_gettext("Help Topics"),
        "parent" => ""
    ),
    "report" => array(
        "title"  => ev_gettext("Reporting Issues"),
        "parent" => "main"
    ),
    "report_category" => array(
        "title"  => ev_gettext("Category Field"),
        "parent" => "report"
    ),
    "report_priority" => array(
        "title"  => ev_gettext("Priority Field"),
        "parent" => "report"
    ),
    "report_assignment" => array(
        "title"  => ev_gettext("Assignment Field"),
        "parent" => "report"
    ),
    "report_release" => array(
        "title"  => ev_gettext("Scheduled Release Field"),
        "parent" => "report"
    ),
    "report_summary" => array(
        "title"  => ev_gettext("Summary Field"),
        "parent" => "report"
    ),
    "report_description" => array(
        "title"  => ev_gettext("Description Field"),
        "parent" => "report"
    ),
    "report_estimated_dev_time" => array(
        "title"  => ev_gettext("Estimated Development Time Field"),
        "parent" => "report"
    ),
    "scm_integration" => array(
        "title"  => ev_gettext("SCM Integration"),
        "parent" => "main"
    ),
    "scm_integration_usage" => array(
        "title"  => ev_gettext("Usage Examples"),
        "parent" => "scm_integration"
    ),
    "scm_integration_installation" => array(
        "title"  => ev_gettext("Installation Instructions"),
        "parent" => "scm_integration"
    ),
    "list" => array(
        "title"  => ev_gettext("Listing / Searching for Issues"),
        "parent" => "main"
    ),
    "adv_search" => array(
        "title"  => ev_gettext("Advanced Search / Creating Custom Queries"),
        "parent" => "main"
    ),
    "support_emails" => array(
        "title"  => ev_gettext("Associate Emails"),
        "parent" => "main"
    ),
    "preferences" => array(
        "title"  => ev_gettext("Account Preferences"),
        "parent" => "main"
    ),
    "notifications" => array(
        "title"  => ev_gettext("Email Notifications"),
        "parent" => "main"
    ),
    "view" => array(
        "title"  => ev_gettext("Viewing Issues"),
        "parent" => "main"
    ),
    "email_blocking" => array(
        "title"  => ev_gettext("Email Blocking"),
        "parent" => "main"
    ),
    "link_filters" => array(
        "title"  => ev_gettext("Link Filters"),
        "parent" => "main"
    ),
    "field_display" => array(
        "title"  => ev_gettext("Edit Fields to Display"),
        "parent" => "main"
    ),
    "column_display" => array(
        "title"  => ev_gettext("Edit Columns to Display"),
        "parent" => "main"
    ),
    "customize_listing" => array(
        "title"  => ev_gettext("Customize Issue Listing Screen"),
        "parent" => "main"
    ),
    "segregate_reporter" => array(
        "title"  => ev_gettext("Segregate Reporters"),
        "parent" => "main"
    ),
    "permission_levels" => array(
        "title"  => ev_gettext("User Permission Levels"),
        "parent" => "main"
    ),
);

/**
 * Class to handle the business logic related to the help
 * documentation, such as providing a dynamic list of topics related
 * to the current topic and such.
 *
 * @version 1.0
 * @author João Prado Maia <jpm@mysql.com>
 */

class Help
{
    /**
     * Method used to check whether a specific topic exists or not.
     * This is mainly used in the help documentation main page to see
     * if a requested topic exists, and to show a default one
     * otherwise.
     *
     * @access  public
     * @param   string $topic The topic title to check for
     * @return  boolean Whether the topic exists or not
     */
    function topicExists($topic)
    {
        global $topics;

        if (isset($topics[$topic])) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Method used to get the parent help documentation topic
     * associated with a specific topic title.
     *
     * @access  public
     * @param   string $topic The topic title
     * @return  array The information related to the parent help topic
     */
    function getParent($topic)
    {
        global $topics;

        $child = @$topics[$topic];
        if (empty($child["parent"])) {
            return false;
        } else {
            return array(
                "topic" => $child["parent"],
                "title" => $topics[$child["parent"]]["title"]
            );
        }
    }


    /**
     * Method used to get all the help topics related to a specific
     * 'parent' one.
     *
     * @access  public
     * @param   string $topic The 'parent' help topic
     * @return  array The list of help topics
     */
    function getChildLinks($topic)
    {
        global $topics;

        $links = array();
        foreach ($topics as $child => $data) {
            if ($data["parent"] == $topic) {
                $links[] = array(
                    "topic" => $child,
                    "title" => $data["title"]
                );
            }
        }
        if (count($links) == 0) {
            return "";
        } else {
            return $links;
        }
    }


    /**
     * Method used to get all of the navigation links related to a
     * specific help topic.
     *
     * @access  public
     * @param   string $topic The topic title
     * @return  array The list of navigation links
     */
    function getNavigationLinks($topic)
    {
        global $topics;

        $links = array();
        $links[] = @array(
            "topic" => "",
            "title" => $topics[$topic]["title"]
        );
        while ($parent = Help::getParent($topic)) {
            $links[] = array(
                "topic" => $parent["topic"],
                "title" => $parent["title"]
            );
            $topic = $parent["topic"];
        }
        $links = array_reverse($links);
        return $links;
    }
}

// benchmarking the included file (aka setup time)
if (APP_BENCHMARK) {
    $GLOBALS['bench']->setMarker('Included Help Class');
}
?>
