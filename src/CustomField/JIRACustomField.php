<?php
// This file assumes that the Customfield Editor Plugin for JIRA is installed.

namespace rkjohnson2005\JIRARest;

class JIRACustomField extends JIRARest {
    public function getCustomFields() {
        $request = $this->client->get('/rest/jiracustomfieldeditorplugin/1/user/customfields', $this->auth);
        $body = json_decode($request->getBody()->getContents());
        return $body;
    }

    public function getCustomFieldContexts($customfield_id) {
        $request = $this->client->get("/rest/jiracustomfieldeditorplugin/1/user/customfields/{$customfield_id}/contexts", $this->auth);
        $body = json_decode($request->getBody()->getContents());
        return $body;
    }

    public function getContextOptions($customfield_id, $context_id) {
        $request = $this->client->get("/rest/jiracustomfieldeditorplugin/1/user/customfields/{$customfield_id}/contexts/{$context_id}/options", $this->auth);
        $body = json_decode($request->getBody()->getContents());
        return $body;
    }
}