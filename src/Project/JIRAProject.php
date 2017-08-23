<?php

namespace rkjohnson2005\JIRARest;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;


class JIRAProject extends JIRARest
{
    public function getProjects()
    {
        $request = $this->client->get('/rest/api/latest/project', $this->auth);
        $body = json_decode($request->getBody()->getContents());

        return $body;
    }

    public function getProjectIssuetypes($project) {
        $request = $this->client->get('/rest/api/latest/issue/createmeta', $this->auth);
        $body = json_decode($request->getBody()->getContents());
        foreach ($body->projects AS $jira_project) {
            if ($jira_project->key == $project || $jira_project->id == $project) {
                return $jira_project->issuetypes;
            }
        }
        return null;
    }

    public function getIssues($project, $fields = '')
    {
        if (is_array($fields)) {
            $fields = "&fields=".implode(',',$fields);
        }
        $request = $this->client->get('/rest/api/latest/search?jql='.urlencode("project=".$project). $fields .'&maxResults=-1', $this->auth);
        $issues = json_decode($request->getBody()->getContents());
        return $issues->issues;
    }
}