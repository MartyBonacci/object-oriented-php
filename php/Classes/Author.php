<?php
namespace MartyBonacci\ObjectOrientedPhp;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use http\Exception\BadQueryStringException;
use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * This is the Author class
 * @author Marty Bonacci <mbonacci@cnm.edu>
 */
class Author implements \JsonSerializable{

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
    public function __construct($newAuthorId,string $newAuthorActivationToken,?string $newAuthorAvatarUrl,string $newAuthorEmail,string $newAuthorHash,string $newAuthorUsername){
        try{
            $this->setAuthorId($newAuthorId);
            $this->setAuthorActivationToken($newAuthorActivationToken);
            $this->setAuthorAvatarUrl($newAuthorAvatarUrl);
            $this->setAuthorEmail($newAuthorEmail);
            $this->setAuthorHash($newAuthorHash);
            $this->setAuthorUsername($newAuthorUsername);

        }catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for author id
     *
     * @return Uuid value of author id
     */
    public function getAuthorId() :Uuid {
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
    public function setAuthorId($newAuthorId): void{
        try{
            $uuid = self::validateUuid($newAuthorId);
        }catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
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
     *@param string $newAuthorActivationToken
     *@throws \InvalidArgumentException if the token is not a string or is insecure
     *@throws \RangeException if the token is not exactly 32 characters
     *@throws \TypeError if the activation token is not a string
     */
    public function setAuthorActivationToken(?string $newAuthorActivationToken): void{

        if($newAuthorActivationToken === null) {
            $this->authorActivationToken = null;
            return;
        }

        $newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
        if(ctype_xdigit($newAuthorActivationToken) === false) {
            throw(new\RangeException("author activation is not valid"));
        }

        //make sure user activation token is only 32 characters
        if(strlen($newAuthorActivationToken) !== 32) {
            throw(new\RangeException("author activation token has to be 32 characters"));
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
    public function setAuthorAvatarUrl(?string $newAuthorAvatarUrl): void{

        $newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
        $newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        // verify the avatar URL will fit in the database
        if(strlen($newAuthorAvatarUrl) > 255) {
            throw(new \RangeException("avatar url too long, must be less than 256 characters"));
        }
        $this->authorAvatarUrl = $newAuthorAvatarUrl;
    }





    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}