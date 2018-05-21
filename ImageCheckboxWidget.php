<?php
namespace aminkt\widgets\imageCheckbox;

use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;
use yii\web\View;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * AmChart Widget For Yii2
 *
 * @author Sérgio Peixoto <matematico2002@hotmail.com>
 *
 * @link https://github.com/speixoto/yii2-amcharts
 * @link http://www.amcharts.com/
 */
class ImageCheckboxWidget extends InputWidget
{
    /**
     * @var array The HTML attributes for the div wrapper tag.
     */
    public $options = [];

    /**
     * @var bool Multiple image selection or not.
     */
    public $multiple = true;

    /**
     * @var array Images that should convert to checkable.
     *
     * <code>
     * [
     *       [
     *          'src' => 'Img address',
     *          // Other Img tag options.
     *      ]
     * ]
     * </code>
     */
    public $images = [];
    
    /**
     * @var array the ImageCheckbox configuration array
     * @see https://github.com/jcuenod/imgCheckbox
     */
    public $pluginOptions = [];

    /**
     * @var int Count of images.
     */
    private $count = 0;

    private $inputName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if(($this->count = count($this->images)) == 0){
            throw new InvalidArgumentException("Please add some images.");
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = 'imageCheckbox_' . $this->getId();
        }

        if(!$this->multiple) {
            $this->pluginOptions['radio'] = true;
            $this->pluginOptions['canDeselect'] = true;
        }
        $this->id = $this->options['id'];

        if($this->hasModel()){
            $this->inputName = Html::getInputName($this->model, $this->attribute);
            $this->value = Html::getAttributeValue($this->model, $this->attribute);
        }else{
            $this->inputName = $this->name;
        }

        ImageCheckboxAssets::register($this->view);

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->generateJs();
        return $this->generateHtml();
    }

    /**
     * Generate html data.
     *
     * @return string
     */
    private function generateHtml(){
        $html = '';
        foreach ($this->images as $key => $options) {
            $options['name'] = $this->inputName.'['.$key.']';
            if(isset($options['class'])){
                $options['class'] .= $this->id.'_img';
            }else{
                $options['class'] = $this->id.'_img';
            }
            $html .= Html::img($options['src'], $options);
        }
        return $html;
    }

    /**
     * Generate js data.
     */
    private function generateJs(){
        if($this->value and !empty($this->value)){
            $selected = [];
            if(!is_array($this->value)){
                $values = explode(',', $this->value);
            }else{
                $values = $this->value;
            }
            foreach ($values as $value){
                $selected[] = array_search($value, array_keys($this->images));
            }
            $this->pluginOptions['preselect'] = $selected;
        }

        $selector = $this->id.'_img';
        $options = Json::encode($this->pluginOptions);
        $js = <<<JS
jQuery(".{$selector}").imgCheckbox({$options});
JS;
        $this->view->registerJs($js);
    }
}
