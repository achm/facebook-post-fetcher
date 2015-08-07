<?php
require 'vendor/autoload.php';

$appId = getenv('FACEBOOK_APP_ID');
$appSecret = getenv('FACEBOOK_APP_SECRET');
$accessToken = getenv('FACEBOOK_ACCESS_TOKEN');
$pageId = getenv('FACEBOOK_PAGE_ID');

$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.4',
  'default_access_token' => $accessToken
]);

$request = $fb->request('GET', "/{$pageId}/feed");
$response = $fb->getClient()->sendRequest($request);
$feeds = $response->getGraphEdge();

foreach ($feeds as $feed) {
  $id = $feed->getField('id');
  $url = htmlspecialchars("https://www.facebook.com/{$id}", ENT_QUOTES);
  $message = str_replace("\n", '', $feed->getField('message'));
  $title = htmlspecialchars(mb_substr($message, 0, 30, 'UTF-8'), ENT_QUOTES);

  echo "<a href=\"{$url}\" target=\"_blank\">";
  echo "<h1>{$title}...</h1>";
  echo "</a>";
}
