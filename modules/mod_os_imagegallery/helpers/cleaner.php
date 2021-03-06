<?php
/**
 * @package OS_ImageGallery
 * @subpackage  mod_OS_ImageGallery
 * @copyright Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Anton Panchenko(nix-legend@mail.ru); Sergey Bunyaev(sergey@bunyaev.ru); Sergey Solovyev(solovyev@solovyev.in.ua)
 * @version: 1.0 
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * */
defined('_JEXEC') or die;
if(!function_exists('checkFiles')){
    function checkFiles($items, $moduleId) {
        $files = array();
        if (is_array($items)) {
            foreach ($items as $item) {
                $files[$item->file] = true;
            }
        }

        $dir = JPATH_ROOT . '/images/os_imagegallery_' . $moduleId;
        delete_old($files, $dir . '/manager');
        delete_old($files, $dir . '/original');
        delete_old($files, $dir . '/thumbnail');
    }
}

jimport('joomla.filesystem.folder');
if(!function_exists('delete_old')){
    function delete_old($files, $dir) {
        if (!JFolder::exists($dir)) return;
        foreach (JFolder::files($dir) as $file) {
            if (!array_key_exists($file, $files)) {
                JFile::delete($dir . '/' . $file);
            }
        }
    }
}