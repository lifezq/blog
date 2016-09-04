<?php
/*
 *xhc_weather_setting.php
 *design by XiaoHuochai
 */
!defined('EMLOG_ROOT')&&exit('access deined');

function plugin_setting_view()
{
include(EMLOG_ROOT.'/content/plugins/xhc_weather/xhc_weather_config.php');
?>
<script type="text/javascript">
function myKeyDown(e){
  if(window.event){//IE
    var k = e.keyCode;
    if ((k == 13)||(k == 9) || (k == 35) || (k == 36) || (k == 8) || (k == 46) || (k >= 48 && k <=57 )||( k >= 96 && k <= 105)||(k >= 37 && k <= 40)){
    }else{
      window.event.returnValue = false;
    }
  }else{//火狐
    var k = e.which;
    if ((k == 13)||(k == 9) || (k == 35) || (k == 36) || (k == 8) || (k == 46) || ( k>= 48 && k <= 57)||(k >= 96 && k <= 105)||(k >= 37 && k <= 40)){
    }else{
      e.preventDefault();
    }
  }
}
setTimeout(hideActived,2600);
</script>
<div class=containertitle> <b>水印设置</b>
  <?php if(isset($_GET['setting'])):?>
  <span class="actived">设置成功</span>
  <?php endif;?></div>
<div class=line></div>
<form action="./plugin.php?plugin=xhc_weather&action=setting" method="POST">
  天气预报设置：
  <br />

  <table width="600" border="1">
    <tr>
      <td width="80">父级选择器：</td>
      <td>
        <input type="text" name="parentText" size="30" maxlength="30" value="<?php echo parentText; ?>" style="width:150px;" />支持 jQuery/CSS3 选择器</td>
    </tr>
    <tr>
      <td>移动范围：</td>
      <td>
        <input name="moveArea" type="radio" value="all" <?php if(moveArea == 'all') echo 'checked'; ?> />
        <label>在整个网页中移动</label>
        <input name="moveArea" type="radio" value="limit" <?php if(moveArea == 'limit') echo 'checked'; ?> />
        <label>只能在父级选择器移动</label>
      </td>
    </tr>
    <tr>
      <td>z-index：</td>
      <td>
        <input name="zIndex" type="text"  value="<?php echo zIndexNum; ?>" maxlength="5" />（如果遮住了网页元素，可以设置小一些）</td>
    </tr>
    <tr>
      <td>是否移动：</td>
      <td>
        <input name="move" type="radio" value="1" <?php if(IsMove == '1') echo 'checked'; ?> />
        <label>自动移动位置</label>
        <input name="move" type="radio" value="0" <?php if(IsMove == '0') echo 'checked'; ?> />
        <label>位置固定</label>
      </td>
    </tr>
    <tr>
      <td>是否允许移动：</td>
      <td>
        <input name="drag" type="radio" value="1" <?php if(IsDrag == '1') echo 'checked'; ?> />
        <label>允许拖动</label>
        <input name="drag" type="radio" value="0" <?php if(IsDrag == '0') echo 'checked'; ?> />
        <label>禁止拖动</label>
      </td>
    </tr>
    <tr>
      <td>下雨/雪：</td>
      <td>
        <input name="autoDrop" type="radio" value="0" <?php if(IsAutoDrop == '0') echo 'checked'; ?> />
        <label>鼠标放上去才开始下雨雪</label>
        <input name="autoDrop" type="radio"  value="1" <?php if(IsAutoDrop == '1') echo 'checked'; ?> />
        <label>自动下雨/雪</label>
      </td>
    </tr>
    <tr>
      <td>图标大小：</td>
      <td>
        <input name="styleSize" type="radio" value="big" <?php if(styleSize == 'big') echo 'checked'; ?> />
        <label>大尺寸（100px * 100px）</label>
        <input name="styleSize" type="radio" value="small" <?php if(styleSize == 'small') echo 'checked'; ?> />
        <label>小尺寸（50px * 50px）</label>
      </td>
    </tr>
    <tr>
      <td>选择风格：</td>
      <td>
        <table>
          <tr>
            <td>
              <input name="style" type="radio" value="default" <?php if(style == 'default') echo 'checked'; ?>/></td>
            <td>
              <img alt="default" title="default" src="../content/plugins/xhc_weather/images/default/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="medialoot" <?php if(style == 'medialoot') echo 'checked'; ?>/></td>
            <td>
              <img alt="medialoot" title="medialoot" src="../content/plugins/xhc_weather/images/medialoot/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="meteocons" <?php if(style == 'meteocons') echo 'checked'; ?>/></td>
            <td>
              <img alt="meteocons" title="meteocons" src="../content/plugins/xhc_weather/images/meteocons/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="blue" <?php if(style == 'blue') echo 'checked'; ?>/></td>
            <td>
              <img alt="blue" title="blue" src="../content/plugins/xhc_weather/images/blue/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="cartoon-1" <?php if(style == 'cartoon-1') echo 'checked'; ?>/></td>
            <td>
              <img alt="cartoon-1" title="cartoon-1" src="../content/plugins/xhc_weather/images/cartoon-1/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="cartoon-2" <?php if(style == 'cartoon-2') echo 'checked'; ?>/></td>
            <td>
              <img alt="cartoon-2" title="cartoon-2" src="../content/plugins/xhc_weather/images/cartoon-2/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="cartoon-3" <?php if(style == 'cartoon-3') echo 'checked'; ?>/></td>
            <td>
              <img alt="cartoon-3" title="cartoon-3" src="../content/plugins/xhc_weather/images/cartoon-3/thumb.png"></td>
          </tr>
          <tr>
            <td>
              <input name="style" type="radio" value="_random" <?php if(style == '_random') echo 'checked'; ?> /></td>
            <td>
              <label>每次随机出现一种</label>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>天气情况：</td>
      <td>
        <input name="area" type="radio" value="client" <?php if(area == 'client') echo 'checked'; ?> />
        <label>
          显示访问者所在地区（IP判断）的天气预报 <strong>（支持全世界所有城市）</strong>
        </label>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input name="area" type="radio" value="assign" <?php if(area == 'assign') echo 'checked'; ?> />
        <label>固定显示城市</label>
        ：
        <select name="province" id="province"></select>
        <input type="hidden" id="provincename" value="<?php echo provinceName; ?>" >
        <select name="city" id="city"></select>
        <input type="hidden" id="cityname" value="<?php echo cityName; ?>" >
        的天气预报
      </td>
    </tr>

  </table>
  <input type="submit" value="提 交" />
</form>
<div style="margin-top:20px; padding:5px; width:650px; border:1px dashed #CCC">
  <p> <font color="Red"><b>小提示：</b>
      <br /></font> 
    该插件基于
    <a href="http://julying.com/blog/jquery-weather-v3-clouds-plug-in/" target="_blank">julying.com</a>
    的天气预报插件移植
  </p>
</div>
<script src="../content/plugins/xhc_weather/js/city.js" type="text/javascript"></script>
<script src="../content/plugins/xhc_weather/js/setting.js" type="text/javascript"></script>
<?php
}
function plugin_setting()
{
  $fso = fopen(EMLOG_ROOT.'/content/plugins/xhc_weather/xhc_weather_config.php','r');
  $config = fread($fso,filesize(EMLOG_ROOT.'/content/plugins/xhc_weather/xhc_weather_config.php'));
  fclose($fso);
  $parentText = htmlspecialchars(trim($_POST['parentText']),ENT_QUOTES);
  $moveArea = htmlspecialchars(trim($_POST['moveArea']),ENT_QUOTES);
  $zIndex = intval(trim($_POST['zIndex']));
  $move = intval(trim($_POST['move']));
  $drag = intval(trim($_POST['drag']));
  $autoDrop=intval(trim($_POST['autoDrop']));
  $styleSize=htmlspecialchars(trim($_POST['styleSize']),ENT_QUOTES);
  $style=htmlspecialchars(trim($_POST['style']),ENT_QUOTES);
  $area=htmlspecialchars(trim($_POST['area']),ENT_QUOTES);
  $province=htmlspecialchars(trim($_POST['province']),ENT_QUOTES);
  $city = htmlspecialchars(trim($_POST['city']),ENT_QUOTES);
  $pattern = array(
    "/define\('parentText',(.*)\)/",
    "/define\('moveArea',(.*)\)/",
    "/define\('zIndexNum',(.*)\)/",
    "/define\('IsMove',(.*)\)/",
    "/define\('IsDrag',(.*)\)/",
    "/define\('IsAutoDrop',(.*)\)/",
    "/define\('styleSize',(.*)\)/",
    "/define\('style',(.*)\)/",
    "/define\('area',(.*)\)/",
    "/define\('provinceName',(.*)\)/",
    "/define\('cityName',(.*)\)/",
    );
  $replace = array(
    "define('parentText','".$parentText."')",
    "define('moveArea','".$moveArea."')", 
    "define('zIndexNum','".$zIndex."')",
    "define('IsMove','".$move."')",
    "define('IsDrag','".$drag."')",
    "define('IsAutoDrop','".$autoDrop."')",
    "define('styleSize','".$styleSize."')",
    "define('style','".$style."')",
    "define('area','".$area."')",
    "define('provinceName','".$province."')",
    "define('cityName','".$city."')",
    );
  $new_config = preg_replace($pattern, $replace, $config);
  $fso = fopen(EMLOG_ROOT.'/content/plugins/xhc_weather/xhc_weather_config.php','w');
  fwrite($fso,$new_config);
  fclose($fso);
}
?>