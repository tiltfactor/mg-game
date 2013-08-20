<?php
class ContentController extends CController
{
    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'wsdl' => array(
                'class' => 'CWebServiceAction',
                'classMap' => array(
                    'Status' => 'Status',
                    'RegisterResult' => 'RegisterResult'
                ),
            ),
        );
    }


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $url
     * @return RegisterResult
     * @soap
     */
    public function register($name, $email, $password, $url)
    {
        return RegisterResult::error(StatusCode::SUCCESS(), "");
    }

    /**
     * @param $token
     * @return Status
     * @soap
     */
    public function createCollection($token)
    {
        return Status::getStatus(StatusCode::SUCCESS(), "");
    }

    /**
     * @param $token
     * @return Status
     * @soap
     */
    public function updateCollection($token)
    {
        return Status::getStatus(StatusCode::SUCCESS(), "");
    }

    /**
     * @param $token
     * @return Status
     * @soap
     */
    public function deleteCollection($token)
    {
        return Status::getStatus(StatusCode::SUCCESS(), "");
    }

    /**
     * @param $token
     * @return Status
     * @soap
     */
    public function createMedia($token)
    {
        return Status::getStatus(StatusCode::SUCCESS(), "");
    }

    /**
     * @param $token
     * @return Status
     * @soap
     */
    public function assignMediaToCollection($token)
    {
        return Status::getStatus(StatusCode::SUCCESS(), "");
    }

    /**
     * @param $token
     * @return Status
     * @soap
     */
    public function removeMediaFromCollection($token)
    {
        return Status::getStatus(StatusCode::SUCCESS(), "");
    }
}
