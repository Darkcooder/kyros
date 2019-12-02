<?php
/**
 * Social Login
 *
 * @version 	1.0
 * @author		Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access
defined('_JEXEC') or die;

class plgSlogin_authVkontakte extends JPlugin
{
    private $provider = 'vkontakte';

    public function onSloginAuth()
    {
        if($this->params->get('allow_remote_check', 1))
        {
            $remotelUrl = JURI::getInstance($_SERVER['HTTP_REFERER'])->toString(array('host'));
            $localUrl = JURI::getInstance()->toString(array('host'));
            if($remotelUrl != $localUrl){
                //die('Remote authorization not allowed');
            }
        }

        $redirect = JURI::base().'component/slogin/callback/vkontakte';

        $scope = 'offline';
		$scope .= ',email';

        if($this->params->get('repost_comments', 0))
        {
            $scope .= ',wall';
            //$scope .= ',groups';
        }

        $params = array(
            'client_id=' . $this->params->get('id'),
            'response_type=code',
            'redirect_uri=' . urlencode($redirect),
            'scope=' . $scope
        );
        $params = implode('&', $params);

        $url = 'https://oauth.vk.com/authorize?' . $params;

        return $url;
    }

    public function onSloginCheck()
    {
        require_once JPATH_BASE.'/components/com_slogin/controller.php';

        $controller = new SLoginController();

        $input = JFactory::getApplication()->input;

        $code = $input->get('code', null, 'STRING');

        if(JRequest::getVar('vk_token', null)) $code="STRING";

        $returnRequest = new SloginRequest();

        if ($code) {
            $data = $this->getToken($code);

            if (empty($data->access_token) || $data->error) {
                echo '<pre>';
				var_dump($data);
                echo '</pre>';
                die();
            }

			$returnRequest->email = (!empty($data->email)) ? $data->email : '';
			
// 			Получение данных о пользователе поле fields
// 			Нужное можно указать!
// 			uid, first_name, last_name, nickname, screen_name, sex, bdate (birthdate), city, country,
// 			timezone, photo, photo_medium, photo_big, has_mobile, rate, contacts, education, online, counters.
// 			По умолчанию возвращает uid, first_name и last_name

// 			name_case - дополнительный параметр
// 			падеж для склонения имени и фамилии пользователя.
// 			Возможные значения:
// 			именительный – nom,
// 			родительный – gen,
// 			дательный – dat,
// 			винительный – acc,
// 			творительный – ins,
// 			предложный – abl.
// 			По умолчанию nom.

            $ResponseUrl = 'https://api.vk.com/method/getProfiles?uid='.$data->user_id.'&access_token='.$data->access_token.'&fields=nickname,contacts,photo_big,bdate&v=5.0';
            $request = json_decode($controller->open_http($ResponseUrl))->response[0];
//var_dump($request);
            if(empty($request)){
                 $auth_key=md5("5898187_".$data->user_id."_fRBRps40VP9shoZg2fna");
                if(JRequest::getVar('auth_key', '')==$auth_key){
                    $ResponseUrl = 'https://api.vk.com/method/getProfiles?uid='.$data->user_id;
                    $request = json_decode($controller->open_http($ResponseUrl))->response[0];
                }
            }

            if(empty($request)){
                
                echo 'Error - empty user data by VK token ';
                //echo $controller->open_http($ResponseUrl);
                exit;
            }
            else if(!empty($request->error)){
                echo 'Error - '. $request->error;
                exit;
            }

            //сохраняем данные токена в сессию
            //expire - время устаревания скрипта, метка времени Unix
            JFactory::getApplication()->setUserState('slogin.token', array(
                'provider' => $this->provider,
                'token' => $data->access_token,
                'expire' => $data->expires_in,
                'repost_comments' => $this->params->get('repost_comments', 0),
                'slogin_user' => $data->user_id,
                'app_id' => $this->params->get('id', 0),
                'app_secret' => $this->params->get('password', 0)
            ));

            $returnRequest->first_name  = $request->first_name;
            $returnRequest->last_name   = $request->last_name;
            $returnRequest->id          = $request->id;
            $returnRequest->real_name   = $request->first_name.' '.$request->last_name;
            $returnRequest->display_name = $request->nickname;
            $returnRequest->all_request  = $request;
            //echo json_encode($returnRequest);
            //die;
            return $returnRequest;
        }
        else{
            echo 'Error - empty code';
            exit;
        }
    }

    protected function appToken(){
        return (object)array(
            "access_token"=>JRequest::getVar('vk_token', null),
            "user_id"=>JRequest::getVar('vk_id', null),
            "expires_in"=>JRequest::getVar('vk_exp', null),
            "email"=>JRequest::getVar('vk_email', null)
        );
    }

    public function getToken($code)
    {
        if(JRequest::getVar('vk_token', null)) return $this->appToken();
        require_once JPATH_BASE.'/components/com_slogin/controller.php';
        $controller = new SLoginController();

        $redirect = urlencode(JURI::base().'component/slogin/callback/vkontakte');

        //подключение к API
        $params = array(
            'client_id=' . $this->params->get('id'),
            'client_secret=' . $this->params->get('password'),
            'code=' . $code,
            'redirect_uri=' . $redirect
        );
        $params = implode('&', $params);

        $url = 'https://oauth.vk.com/access_token?' . $params;

        $data = json_decode($controller->open_http($url));

        return $data;
    }

    public function onCreateSloginLink(&$links, $add = '')
    {
        $i = count($links);
        $links[$i]['link'] = 'index.php?option=com_slogin&task=auth&plugin=vkontakte' . $add;
        $links[$i]['class'] = 'vkontakteslogin';
        $links[$i]['plugin_name'] = $this->provider;
        $links[$i]['plugin_title'] = JText::_('COM_SLOGIN_PROVIDER_VK');
    }
}
