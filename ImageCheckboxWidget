<?php
namespace aminkt\widgets\imageCheckbox;

use Yii;
use yii\web\View;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * AmChart Widget For Yii2
 *
 * @author Sérgio Peixoto <matematico2002@hotmail.com>
 *
 * @link https://github.com/speixoto/yii2-amcharts
 * @link http://www.amcharts.com/
 */
class ImageCheckboxWidget extends \yii\base\Widget
{
    /**
     * @var array The HTML attributes for the div wrapper tag.
     */
    public $options = [];
    
    /**
     * @var array the ImageCheckbox configuration array
     * @see https://github.com/jcuenod/imgCheckbox
     */
    public $pluginOptions = [];

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = 'imageCheckbox_' . $this->getId();
        }
        $this->id = $this->options['id'];
        parent::init();
    }

    public function run()
    {
        
    }
}
