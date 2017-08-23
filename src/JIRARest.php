<?php

namespace rkjohnson2005\JIRARest;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;


class JIRARest
{
    protected $client;
    protected $auth;

    public function __construct($server = NULL, $user = NULL, $password = NULL)
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $server ?? env("JIRA_SERVER"),
            // You can set any number of default request options.
            'timeout'  => 5.0,
            'proxy' => '',
        ]);

        $user  = $user ?? env("JIRA_USER");
        $password = $password ?? env("JIRA_PASSWORD");

        $this->auth = ['auth' => [$user, $password]];
    }

    public function getSelectData($json_array, $id_field, $value_field)
    {
        $select_data = [];
        foreach ($json_array AS $item) {
            $id_fields = explode('->', $id_field);
            $end = end($id_fields);
            $id_item = $item;
            foreach ($id_fields AS $field) {
                if ($end != $field) {
                    $id_item = $id_item->$field;
                } else {
                    $id_field_value = $id_item->{$field};
                }
            }
            
            $value_fields = explode('->', $value_field);
            $end = end($value_fields);
            $value_item = $item;
            foreach ($value_fields AS $field) {
                if ($end != $field) {
                    $value_item = $value_item->$field;
                } else {
                    $value_field_value = $value_item->{$field};
                }
            }
            $select_data[$id_field_value] = $value_field_value;
        }
        return $select_data;
    }

    // Issue Functions
    public function getIssues($project)
    {
        $request = $this->client->get('/rest/api/latest/search?jql='.urlencode("project=".$project).'&maxResults=250', $this->auth);
        $body = json_decode($request->getBody()->getContents());
        return $body->issues;
    }

    public function getIssue($issue)
    {
        $request = $this->client->get('/rest/api/latest/issue/'.$issue, $this->auth);
        $body = $request->getBody();
        return $body;
    }

    public function getIssueComments($issue)
    {
        $request = $this->client->get("/rest/api/latest/issue/{$issue}?expand=renderedFields", $this->auth);
        $body = json_decode($request->getBody()->getContents());
        return $body->renderedFields->comment->comments;
    }


    // Field Functions
    public function getFields() {
        $request = $this->client->get('/rest/api/latest/field', $this->auth);
        $body = $request->getBody();
        return $body;
    }

    public function getFieldInputs($key) {
        $issue = json_decode(app('rkjohnson2005\JIRARest\JIRARestController')->getIssue($key)->getContents());
        $inputs = [];
        dd($issue);
        foreach($issue->fields AS $field_name => $field_parameters) {
            switch ($field_name) {
                case 'issuetype':
                    $issuetypes = app('rkjohnson2005\JIRARest\JIRARestController')->getProjectIssueTypes($issue->fields->project->key);
                    $types = [];
                    foreach ($issuetypes AS $issuetype) {
                        $types[$issuetype->id] = $issuetype->name;
                    }
                    view('JIRARest::select', ['issuetypes' => $types, 'selected' => $field_parameters->id]);
            }
        }
    }
}