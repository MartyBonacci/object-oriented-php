<?php

namespace MartyBonacci\ObjectOrientedPhp;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This is the Author class
 * @author Marty Bonacci <mbonacci@cnm.edu>
 */
class Author implements \JsonSerializable
{

    use ValidateUuid;

    /**
     * id for this Author; this is the primary key
     * @var Uuid $authorId
     */
    private $authorId;

    /**
     * activation token for this Author
     * @var string $authorActivationToken
     */
    private $authorActivationToken;

    /**
     * avatar url for Author
     * @var string $authorAvatarUrl
     */
    private $authorAvatarUrl;

    /**
     * email for this Author
     * @var string $authorEmail
     */
    private $authorEmail;

    /**
     * hash for Author
     * @var string $authorHash
     */
    private $authorHash;

    /**
     * user name for this Author
     * @var string $authorUsername
     */
    private $authorUsername;

    /**
     * constructor for this Author
     *
     * @param string|Uuid $authorId id of this Author or null if a new Author
     * @param string $authorActivationToken activation token to safe guard against malicious accounts
     * @param string $authorAvatarUrl string containing an avatar url or null
     * @param string $authorEmail string containing an email
     * @param string $authorHash string containing a password hash
     * @param string $authorUsername string containing a user name
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manual/en/language.oop5.decon.php
     */
    public function __construct($newAuthorId, string $newAuthorActivationToken, ?string $newAuthorAvatarUrl, string $newAuthorEmail, string $newAuthorHash, string $newAuthorUsername)
    {
        try {
            $this->setAuthorId($newAuthorId);
            $this->setAuthorActivationToken($newAuthorActivationToken);
            $this->setAuthorAvatarUrl($newAuthorAvatarUrl);
            $this->setAuthorEmail($newAuthorEmail);
            $this->setAuthorHash($newAuthorHash);
            $this->setAuthorUsername($newAuthorUsername);

        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for author id
     *
     * @return Uuid value of author id
     */
    public function getAuthorId(): Uuid
    {
        return ($this->authorId);
    }

    /**
     *mutator method for author id
     *
     * @param Uuid|string $newAuthorId new value of author id
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if #newAuthorId is out of range
     * @throws \TypeError if $newAuthorId is not a uuid or string
     */
    public function setAuthorId($newAuthorId): void
    {
        try {
            $uuid = self::validateUuid($newAuthorId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        //convert and store the author id
        $this->authorId = $uuid;
    }

    /**
     * accessor method for author activation token
     *
     * @return string value of the activation token
     */
    public function getAuthorActivationToken(): ?string
    {
        return $this->authorActivationToken;
    }

    /**
     *mutator method for account activation token
     *
     * @param string $newAuthorActivationToken
     * @throws \InvalidArgumentException if the token is not a string or is insecure
     * @throws \RangeException if the token is not exactly 32 characters
     * @throws \TypeError if the activation token is not a string
     */
    public function setAuthorActivationToken(?string $newAuthorActivationToken): void
    {

        if ($newAuthorActivationToken === null) {
            $this->authorActivationToken = null;
            return;
        }

        try {
            $newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
            if (ctype_xdigit($newAuthorActivationToken) === false) {
                throw(new\RangeException("author activation is not valid"));
            }

            //make sure user activation token is only 32 characters
            if (strlen($newAuthorActivationToken) !== 32) {
                throw(new\RangeException("author activation token has to be 32 characters"));
            }
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->authorActivationToken = $newAuthorActivationToken;
    }

    /**
     * accessor method for author avatar url
     *
     * @return string this author avatar url
     */
    public function getAuthorAvatarUrl(): string
    {
        return $this->authorAvatarUrl;
    }

    /**
     * mutator method for author avatar url
     *
     * @param string $newAuthorAvatarUrl
     * @throws \InvalidArgumentException if the avatar url is not a string or is insecure
     * @throws \RangeException if the avatar url is not more than 255 characters
     * @throws \TypeError if the avatar url is not a string
     */
    public function setAuthorAvatarUrl(?string $newAuthorAvatarUrl): void
    {

        $newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
        $newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        try {
            // verify the avatar URL will fit in the database
            if (strlen($newAuthorAvatarUrl) > 255) {
                throw(new \RangeException("avatar url too long, must be less than 256 characters"));
            }
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->authorAvatarUrl = $newAuthorAvatarUrl;
    }

    /**
     * accessor method for author email
     *
     * @return string author email
     */
    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    /**
     * mutator method for author email
     *
     * @param string $newAuthorEmail
     * @throws \InvalidArgumentException if the email is not an email or is insecure
     * @throws \RangeException if the email is more than 128 characters
     * @throws \TypeError if the email is not a string
     */
    public function setAuthorEmail(string $newAuthorEmail): void
    {
        try {
            // verify the email is secure
            $newAuthorEmail = trim($newAuthorEmail);
            $newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
            if (empty($newAuthorEmail) === true) {
                throw(new \InvalidArgumentException("author email is empty or insecure"));
            }

            // verify the email will fit in the database
            if (strlen($newAuthorEmail) > 128) {
                throw(new \RangeException("author email is too large"));
            }
        }catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->authorEmail = $newAuthorEmail;
    }

    /**
     * accessor for author hash
     *
     * @return string this author hash
     */
    public function getAuthorHash(): string
    {
        return $this->authorHash;
    }

    /**
     * mutator for author hash
     *
     * @param string $newAuthorHash
     * @throws \InvalidArgumentException if the hash is not an argon hash or is insecure
     * @throws \RangeException if the author hash is larger than 97 characters
     * @throws \TypeError if the hash is not a string
     */
    public function setAuthorHash(string $newAuthorHash): void
    {
        try {
            //enforce that the hash is properly formatted
            $newAuthorHash = trim($newAuthorHash);
            if (empty($newAuthorHash) === true) {
                throw(new \InvalidArgumentException("author password hash empty"));
            }

            //enforce the hash is really an Argon hash
            $authorHashInfo = password_get_info($newAuthorHash);
            if ($authorHashInfo["algoName"] !== "argon2id") {
                throw(new \InvalidArgumentException("author hash is not a valid hash"));
            }

            // verify the hash will fit in the database
            if (strlen($newAuthorHash) > 97) {
                throw(new \RangeException("author hash is too large"));
            }
        }catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->authorHash = $newAuthorHash;
    }

    /**
     * accessor for username
     *
     * @return string author username
     */
    public function getAuthorUsername(): string
    {
        return $this->authorUsername;
    }

    /**
     * mutator for username
     *
     * @param string $newAuthorUsername
     * @throws \InvalidArgumentException if the username is empty or insecure
     * @throws \RangeException if the username is larger than 32 characters
     * @throws \TypeError if the username is not a string
     */
    public function setAuthorUsername(string $newAuthorUsername): void
    {
        try {
            // verify the username is secure
            $newAuthorUsername = trim($newAuthorUsername);
            $newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            if (empty($newAuthorUsername) === true) {
                throw(new \InvalidArgumentException("username is empty or insecure"));
            }

            // verify the username will fit in the database
            if (strlen($newAuthorUsername) > 32) {
                throw(new \RangeException("username must be 32 characters or less"));
            }
        }catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        $this->authorUsername = $newAuthorUsername;
    }

    /**
     * inserts this author into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {
        // create query template
        $query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["authorId"=>$this->authorId->getBytes(), "authorActivationToken"=>$this->authorActivationToken, "authorAvatarUrl"=>$this->authorAvatarUrl, "authorEmail"=>$this->authorEmail, "authorHash"=>$this->authorHash, "authorUsername"=>$this->authorUsername];
        $statement->execute($parameters);
    }

    /**
     * deletes this Author from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo): void {

        // create query template
        $query = "DELETE FROM author WHERE authorId = :authorId";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holders in the template
        $parameters = ["authorId" => $this->authorId->getBytes()];
        $statement->execute($parameters);
    }


    /**
     * inserts this author into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) : void {
        // create query template
        $query = "UPDATE author SET authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["authorId"=>$this->authorId->getBytes(), "authorActivationToken"=>$this->authorActivationToken, "authorAvatarUrl"=>$this->authorAvatarUrl, "authorEmail"=>$this->authorEmail, "authorHash"=>$this->authorHash, "authorUsername"=>$this->authorUsername];
        $statement->execute($parameters);
    }


    /**
     * get Author by author id from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $authorId id to search for
     * @return Author|null Author found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable are not the correct data type
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if authorId is out of range
     */
    public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
        // sanitize the authorId before searching
        try {
        $authorId = self::validateUuid($authorId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        // create query template
        $query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
        $statement = $pdo->prepare($query);

        // bind the author id to the place holder in the template
        $parameters = ["authorId" => $authorId->getBytes()];
        $statement->execute($parameters);

        // grab the author from mySQL
        try {
            $author = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($author);
    }

    /**
     * get Authors by author username from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @param string $authorUsername username to search for
     * @return \SplFixedArray SplFixedArray of Authors found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable are not the correct data type
     */
    public static function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername) : \SPLFixedArray{
        // sanitize the description before searching
        $authorUsername = trim($authorUsername);
        $authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($authorUsername) === true) {
            throw(new \PDOException("author username is invalid"));
        }

        // escape any mySQL wild cards
        $authorUsername = str_replace("_", "\\_", str_replace("%", "\\%", $authorUsername));

        // create query template
        $query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorUsername LIKE :authorUsername";
        $statement = $pdo->prepare($query);

        // bind the author username to the place holder in the template
        $authorUsername = "%$authorUsername%";
        $parameters = ["authorUsername" => $authorUsername];
        $statement->execute($parameters);

        // build an array of authors
        $authors = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
                $authors[$authors->key()] = $author;
                $authors->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return($authors);
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $fields = get_object_vars($this);
        $fields["authorId"] = $this->authorId->toString();
        unset($fields["authorActivationToken"]);
        unset($fields["authorHash"]);
        return ($fields);
    }
}