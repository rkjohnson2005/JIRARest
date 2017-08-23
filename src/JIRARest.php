<?php

namespace rjohnson2005\JIRARest;

class JIRARest
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

    public function getProjects()
    {
        $request = $this->client->get('/rest/api/latest/project', $this->auth);
        $body = json_decode($request->getBody()->getContents());;
        return $body;
    }
}