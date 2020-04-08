<?php
namespace MartyBonacci\ObjectOrientedPhp;
require_once(dirname(__DIR__, 1) . "/php/Classes/Author.php");


$authorId = "08180705-1cdd-421d-b8aa-fe0ec7f76fe6";
$authorActivationToken = bin2hex(random_bytes(16));
$authorAvatarUrl = "https://img.jakpost.net/c/2020/04/04/2020_04_04_91800_1585973214._large.jpg";
$authorEmail = "Joe@exotic.com";
$authorHash = password_hash("password", PASSWORD_ARGON2ID, ["time_cost" => 9]);;
$authorUsername = "Joe Exotic";

$joe = new Author($authorId, $authorActivationToken, $authorAvatarUrl, $authorEmail, $authorHash, $authorUsername);
echo $joe->getAuthorId() . " ***** ";
echo $joe->getAuthorActivationToken() . " ***** ";
echo $joe->getAuthorAvatarUrl() . " ***** ";
echo $joe->getAuthorEmail() . " ***** ";
echo $joe->getAuthorHash() . " ***** ";
echo $joe->getAuthorUsername();

