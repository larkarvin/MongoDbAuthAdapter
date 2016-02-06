<?php

namespace Larkarvin;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class MongoDbAuthAdapter implements AdapterInterface
{

    protected $collection;
    protected $identityColumn;
    protected $credentialColumn;
    protected $identity;
    protected $credential;

    /**
     * Sets username and password for authentication
     *
     * @return void
     */
    public function __construct($collection, $identityColumn, $credentialColumn)
    {
        $this->collection = $collection;
        $this->identityColumn = $identityColumn;
        $this->credentialColumn = $credentialColumn;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    public function setCredential($credential)
    {
        $this->credential = $credential;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {
        $criteria = [
                    $this->identityColumn => $this->identity,
                    $this->credentialColumn => $this->credential
                    ];
        $cursor = $this->collection->findOne($criteria);

        if(empty($cursor)){
            return new Result(Result::FAILURE, $this->identity, ['Could not find Credential']);
        }else{
            return new Result(Result::SUCCESS, $this->identity, ['Success']);
        }
    }
}
