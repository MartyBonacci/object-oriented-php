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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}