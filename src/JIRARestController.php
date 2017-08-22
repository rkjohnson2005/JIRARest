<?php
namespace rkjohnson2005\JIRARest;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class JIRARestController extends Controller
{
 private $client;
 private $auth;

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


    // Project Functions
    public function getProjects()
    {
        $request = $this->client->get('/rest/api/latest/project', $this->auth);
        $body = json_decode($request->getBody()->getContents());;
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
}