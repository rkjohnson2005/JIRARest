<?php

namespace rkjohnson2005\JIRARest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JIRARestController extends Controller
{
    public function getCustomFieldContext($location_field_id) {
        // Get Custom Fields
        $jira_custom_field = new JIRACustomField();
        $jira_custom_field_context = $jira_custom_field->getCustomFieldContexts($location_field_id);
        $jira_custom_field_context = $jira_custom_field->getSelectData($jira_custom_field_context, 'contextId', 'contextName');
        return $jira_custom_field_context;
    }

    public function getContextOptions($customdfield_id, $context_id) {
        // Get Context Options
        if ($customdfield_id && $context_id) {
            $jira_custom_field = new JIRACustomField();
            $jira_custom_field_context = $jira_custom_field->getContextOptions($customdfield_id, $context_id);
            $jira_custom_field_context = $jira_custom_field->getSelectData($jira_custom_field_context, 'contextId', 'contextName');
            return $jira_custom_field_context;
        } else {
            return null;
        }
    }
}
