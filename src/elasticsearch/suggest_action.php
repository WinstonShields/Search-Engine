<?php

require '../../vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

if (isset($_POST['text'])) {

    $text = $_POST['text'];

    $query = $client->search([
        'index' => 'dissertations',
        'size' => 10,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['contributor_author' => $text]],
                        ['match' => ['contributor_committeechair' => $text]],
                        ['match' => ['contributor_committeemember' => $text]],
                        ['match' => ['contributor_department' => $text]],
                        ['match' => ['degree_grantor' => $text]],
                        ['match' => ['degree_level' => $text]],
                        ['match' => ['degree_name' => $text]],
                        ['match' => ['description_abstract' => $text]],
                        ['match' => ['description_degree' => $text]],
                        ['match' => ['description_provenance' => $text]],
                        ['match' => ['format_medium' => $text]],
                        ['match' => ['handle' => $text]],
                        ['match' => ['identifier_other' => $text]],
                        ['match' => ['identifier_sourceurl' => $text]],
                        ['match' => ['identifier_uri' => $text]],
                        ['match' => ['publisher' => $text]],
                        ['match' => ['relation_haspart' => $text]],
                        ['match' => ['rights' => $text]],
                        ['match' => ['subject' => $text]],
                        ['match' => ['title' => $text]],
                        ['match' => ['type' => $text]],
                    ]
                ]
            ]
        ]
    ]);

    $results = [];

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }

    $suggestions = [];

    foreach($results as $r) {
        array_push($suggestions, $r['_source']['title']);
    }

    print json_encode($suggestions);
}
