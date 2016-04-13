<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 19.01.2015
 */

class BackendAccessFilter extends CFilter{
    protected $_allowedActions = array();

    /**
     * Performs the pre-action filtering.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action
     * should be executed.
     */
    protected function preFilter($filterChain)
    {
        // By default we assume that the user is allowed access
        $allow = true;

        /**
         * @var $user RWebUser
         */
        $user = Yii::app()->getUser();
        $controller = $filterChain->controller;
        $urlParts = explode('/',$controller->getUniqueId());
        foreach($urlParts as $k=>$v){
            $urlParts[$k] = ucfirst($v);
        }
        $action = $filterChain->action;

        // Check if the action should be allowed


        if( $this->_allowedActions!=='*' && in_array($action->id, $this->_allowedActions)===false )
        {

            // Initialize the authorization item as an empty string
            $authItem = implode('.',$urlParts);
            //exit();


            // Check if user has access to the controller
            if($user->checkAccess($authItem.'.*')){
                $allow = true;
            }
            else{
                // Append the action id to the authorization item name
                $authItem .= '.'.ucfirst($action->id);
                //var_dump($authItem);

                // Check if the user has access to the controller action
                if($user->checkAccess($authItem)){
                    $allow = true;
                }
                else{
                    $allow = false;
                }
            }
        }

        //exit;
        // User is not allowed access, deny access
        if(!$allow){
            $controller->accessDenied();
            return false;
        }

        // Authorization item did not exist or the user had access, allow access
        return true;
    }

    /**
     * Sets the allowed actions.
     * @param string $allowedActions the actions that are always allowed separated by commas,
     * you may also use star (*) to represent all actions.
     */
    public function setAllowedActions($allowedActions)
    {
        if( $allowedActions==='*' )
            $this->_allowedActions = $allowedActions;
        else
            $this->_allowedActions = preg_split('/[\s,]+/', $allowedActions, -1, PREG_SPLIT_NO_EMPTY);
    }

}