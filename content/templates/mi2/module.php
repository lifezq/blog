<?php
/*
 * 侧边栏组件、页面模块
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>

<?php

//widget：blogger
function widget_blogger($title) {
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    include('includes/opinion.php');
    $name = $user_cache[$authorID]['mail'] != '' ? "<a href=\"mailto:" . $user_cache[$authorID]['mail'] . "\">" . $user_cache[$authorID]['name'] . "</a>" : $user_cache[$authorID]['name'];
    ?>
    <div id="blogger" class="side_box">
        <h3><?php echo $title; ?></h3>
        <div id="bloggerinfoimg">
            <?php if (!empty($user_cache[$authorID]['photo']['src'])): ?>
                <img src="<?php echo BLOG_URL . $user_cache[$authorID]['photo']['src']; ?>" alt="blogger" />
    <?php endif; ?>
        </div>
        <span><b><?php echo $name; ?></b>
    <?php echo $user_cache[$authorID]['des']; ?></span>
    </div>
<?php } ?>
<?php

//widget：日历
function widget_calendar($title) {
    ?>
    <div class="side_box">
        <h3><span><?php echo $title; ?></span></h3>
        <div id="calendar"></div>
        <script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
    </div>
<?php } ?>
<?php

//widget：标签
function widget_tag($title) {
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags');
    ?>
    <div id="tag" class="side_box">
        <h3><span><?php echo $title; ?></span></h3>
        <span>
    <?php $str=array('a','c','f','e','d','b','1','2','3','4','5','6','7','8','9','0'); 
          $fontSize=array(12,14,16,18,20,22);
         foreach ($tag_cache as $value): 
        $color=array_rand($str,6);
         $fontS=array_rand($fontSize,1);
        ?>
                <a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇日志" style="color:#<?php echo $str[$color[0]].$str[$color[1]].$str[$color[2]].$str[$color[3]].$str[$color[4]].$str[$color[5]]; ?>;font-size:<?php echo $fontSize[$fontS];?>px;"><?php echo $value['tagname']; ?></a>
    <?php endforeach; ?>
        </span>
    </div>
        <?php } ?>
        <?php

//widget：分类
        function widget_sort($title) {
            global $CACHE;
            $sort_cache = $CACHE->readCache('sort');
            ?>
    <div id="sort" class="side_box">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
    <?php foreach ($sort_cache as $value): ?>
                <li><a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?></a></li>
    <?php endforeach; ?>
        </ul>
    </div>
        <?php } ?>
        <?php

//widget：最新碎语
        function widget_twitter($title) {
            global $CACHE;
            $newtws_cache = $CACHE->readCache('newtw');
            $istwitter = Option::get('istwitter');
            ?>
    <div id="twitter" class="side_box">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
    <?php foreach ($newtws_cache as $value): ?>
        <?php $img = empty($value['img']) ? "" : '<a title="查看图片" class="t_img" href="' . BLOG_URL . str_replace('thum-', '', $value['img']) . '" target="_blank">&nbsp;</a>'; ?>
                <li><span style="display:block; float:left; width:197px; overflow:hidden;"><?php echo $value['t']; ?></span><?php echo $img; ?></li>
    <?php endforeach; ?></ul>
    <?php if ($istwitter == 'y') : ?>
            <p align="right"><a href="<?php echo BLOG_URL . 't/'; ?>">更多&raquo;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
    <?php endif; ?>

    </div>
        <?php } ?>
        <?php

//widget：最新评论
        function widget_newcomm($title) {
            global $CACHE;
            $com_cache = $CACHE->readCache('comment');
            ?>
    <div class="side_box" id="comment">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
    <?php
    foreach ($com_cache as $value):
        $url = Url::comment($value['gid'], $value['page'], $value['cid']);
        ?>
                <li><?php echo $value['name']; ?>
                    : <a href="<?php echo $url; ?>"><?php echo $value['content'] = preg_replace("/\[(([1-4]?[0-9])|50)\]/", '<img src="' . TEMPLATE_URL . 'images/' . 'face/$1.gif" width="30" height="30" style="vertical-align:middle;">', $value['content']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
        <?php } ?>
<?php

//widget：最新日志
function widget_newlog($title) {
    global $CACHE;
    $newLogs_cache = $CACHE->readCache('newlog');
    ?>
    <div class="side_box" id="new_log">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
    <?php foreach ($newLogs_cache as $value): ?>
                <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php

//widget：热门日志
function widget_hotlog($title) {
    $index_hotlognum = Option::get('index_hotlognum');
    $Log_Model = new Log_Model();
    $randLogs = $Log_Model->getHotLog($index_hotlognum);
    ?>
    <div class="side_box" id="hotlog">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
            <?php foreach ($randLogs as $value): ?>
                <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div><div class="space"></div>
<?php } ?>
<?php

//widget：随机日志
function widget_random_log($title) {
    $index_randlognum = Option::get('index_randlognum');
    $Log_Model = new Log_Model();
    $randLogs = $Log_Model->getRandLog($index_randlognum);
    ?>
    <div class="side_box" id="rolllog">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
            <?php foreach ($randLogs as $value): ?>
                <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
    <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>

<?php

//widget：归档
function widget_archive($title) {
    global $CACHE;
    $record_cache = $CACHE->readCache('record');
    ?>
    <div id="record" class="side_box">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
    <?php foreach ($record_cache as $value): ?>
                <li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
    <?php endforeach; ?>
        </ul></div>
<?php } ?>
        <?php

//widget：自定义组件
        function widget_custom_text($title, $content) {
            ?>
    <div class="side_box">
        <h3><span><?php echo $title; ?></span></h3>
        <div>
    <?php echo $content; ?>
        </div>
    </div>
<?php } ?>
<?php

//widget：链接
function widget_link($title) {
    global $CACHE;
    $link_cache = $CACHE->readCache('link');
    ?>
    <div class="side_box" id="link">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
        <?php foreach ($link_cache as $value): ?>
                <li><a rel="nofollow" href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
    <?php endforeach; ?>
        </ul>
    </div><div class="space"></div>
<?php } ?>
    <?php
    //widget：页面底部链接
function widget_link_footer($title) {
    global $CACHE;
    $link_cache = $CACHE->readCache('link');
    ?>
    <div class="footer_link" id="footer_link">
        <h3><span><?php echo $title; ?></span></h3>
        <ul>
        <?php foreach ($link_cache as $value): ?>
                <li><a rel="nofollow" href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
    <?php endforeach; ?>
        </ul>
    </div><div class="space"></div>
<?php } ?>
<?php

//blog：导航
function blog_navi() {
    global $CACHE;
    $navi_cache = $CACHE->readCache('navi');
    ?>
    <ul id="nv">
    <?php
    foreach ($navi_cache as $value):

        $newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = isset($value['isdefault']) && $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
        $current_tab = (BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url']) ? 'current-cat' : 'common';
        ?>
            <li class="<?php echo $current_tab; ?>"><a href="<?php echo $value['url']; ?>" <?php echo $newtab; ?>><?php echo $value['naviname']; ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php } ?>
<?php

//blog：置顶
function topflg($istop) {
    $topflg = $istop == 'y' ? "<img src=" . TEMPLATE_URL . "images/pin_3.gif>" . "<font color=#ff0000 style=" . "font-weight:550" . ">" : '';
    echo $topflg;
}
?>
<?php

//blog：编辑
function editflg($logid, $author) {
    $editflg = ROLE == 'admin' || $author == UID ? '<a href="' . BLOG_URL . 'admin/write_log.php?action=edit&gid=' . $logid . '">编辑»</a>' : '';
    echo $editflg;
}
?>
<?php

//blog：分类
function blog_sort($blogid) {
    global $CACHE;
    $log_cache_sort = $CACHE->readCache('logsort');
    ?>
    <?php if (!empty($log_cache_sort[$blogid])): ?>
        <a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
    <?php endif; ?>
<?php } ?>
<?php

//blog：文件附件
function blog_att($blogid) {
    global $CACHE;
    $log_cache_atts = $CACHE->readCache('logatts');
    $att = '';
    if (!empty($log_cache_atts[$blogid])) {
        $att .= '附件下载：';
        foreach ($log_cache_atts[$blogid] as $val) {
            $att .= '<a href="' . BLOG_URL . $val['url'] . '" target="_blank">' . $val['filename'] . '</a> 附件大小：' . $val['size'];
        }
    }
    echo $att;
}
?>
<?php

//blog：日志标签
function blog_tag($blogid) {
    global $CACHE;
    $log_cache_tags = $CACHE->readCache('logtags');
    if (!empty($log_cache_tags[$blogid])) {
        $tag = '标签:';
        foreach ($log_cache_tags[$blogid] as $value) {
            $tag .= "	<a href=\"" . Url::tag($value['tagurl']) . "\">" . $value['tagname'] . '</a>';
        }
        echo $tag;
    }
}
?>
<?php

//blog：日志作者
function blog_author($uid) {
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $author = $user_cache[$uid]['name'];
    $mail = $user_cache[$uid]['mail'];
    $des = $user_cache[$uid]['des'];
    $title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
    echo '<a href="' . Url::author($uid) . "\" $title>$author</a>";
}
?>
<?php

//blog：相邻日志
function neighbor_log($neighborLog) {
    extract($neighborLog);
    ?>
    <div id="neighborLog">
    <?php if ($prevLog): ?>
            <span title="上一篇">上一篇:</span> <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title']; ?></a>
    <?php endif; ?>
    <?php if ($nextLog && $prevLog): ?>
            <br />
    <?php endif; ?>
    <?php if ($nextLog): ?>
            <span title="下一篇">下一篇:</span><a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title']; ?></a>
    <?php endif; ?>
    </div>
<?php } ?>
<?php

//blog：引用通告
function blog_trackback($tb, $tb_url, $allow_tb) {
    if ($allow_tb == 'y' && Option::get('istrackback') == 'y'):
        ?>
        <div id="trackback_address">
            <p>引用地址: <input type="text" style="width:350px" class="input" value="<?php echo $tb_url; ?>">
                <a name="tb"></a></p>
        </div>
    <?php endif; ?>
    <?php foreach ($tb as $key => $value): ?>
        <ul id="trackback">
            <li><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['title']; ?></a></li>
            <li>BLOG: <?php echo $value['blog_name']; ?></li><li><?php echo $value['date']; ?></li>
        </ul>
    <?php endforeach; ?>
<?php } ?>
<?php

//blog：评论列表
function blog_comments($comments, $params) {
    extract($comments);
    if ($commentStacks):
        ?>
        <a name="comments"></a>
    <?php endif; ?>
    <?php
    $isGravatar = Option::get('isgravatar');
    $comnum = count($comments);
    foreach ($comments as $value) {
        if ($value['pid'] != 0) {
            $comnum--;
        }
    }
    $page = isset($params[5]) ? intval($params[5]) : 1;
    $i = $comnum - ($page - 1) * Option::get('comment_pnum');
    foreach ((array) $commentStacks as $cid):
        $comment = $comments[$cid];
        $comment['poster'] = $comment['url'] ? '<a  rel="nofollow"  href="' . BLOG_URL . 'go.php?url=' . $comment['url'] . '" target="_blank">' . $comment['poster'] . '</a>' : $comment['poster'];
        ?>
        <ol class="commentlist">
            <li class="comment even thread-even depth-1" id="comment-<?php echo $comment['cid']; ?>">
                <div id="div-comment-<?php echo $comment['cid']; ?>" class="comment-body">
                    <a name="<?php echo $comment['cid']; ?>"></a>

                    <div class="comment-author vcard"><?php if ($isGravatar == 'y'): ?><img src="<?php echo $comment['photo'] ? BLOG_URL . str_replace('../', '', $comment['photo']) : getGravatar($comment['mail']); ?>" class="avatar photo" height="40" width="40" rel="nofollow"/><?php endif; ?>
                        <div class="floor">
                            # <?php if ($i == 1) {
            echo "沙发";
        } elseif ($i == 2) {
            echo "板凳";
        } elseif ($i == 3) {
            echo "地板";
        } else {
            echo '' . $i . '楼';
        } ?>
                        </div>
                        <strong><?php echo $comment['poster']; ?></strong>:</div>
                    <p><?php echo $comment['content'] = preg_replace("/\[(([1-4]?[0-9])|50)\]/", '<img src="' . TEMPLATE_URL . 'images/' . 'face/$1.gif"  width="40" height="40" alt="faces">', $comment['content']); ?></p>
                    <div class="clear"></div>
                    <span class="datetime"><?php echo $comment['date']; ?></span>
                    <span class="reply"><a class="comment-reply-link" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">[回复]</a></span>

                </div>
        <?php blog_comments_children($comments, $comment['children']); ?>
            </li>
        </ol>
                                <?php $i--;
                            endforeach; ?>

    <div class="pagelist">
        <div class="page_navi"><?php echo $commentPageUrl; ?></div>
    </div>
                        <?php } ?>
<?php

//blog：子评论列表
function blog_comments_children($comments, $children) {
    $isGravatar = Option::get('isgravatar');
    foreach ($children as $child):
        $comment = $comments[$child];
        $comment['poster'] = $comment['url'] ? '<a  rel="nofollow" href="' . BLOG_URL . 'go.php?url=' . $comment['url'] . '" target="_blank">' . $comment['poster'] . '</a>' : $comment['poster'];
        ?>
        <ul class='children'>
            <li class="comment byuser comment-author-luoxiao136611 bypostauthor odd alt depth-2" id="comment-<?php echo $comment['cid']; ?>">
                <div id="div-comment-<?php echo $comment['cid']; ?>" class="comment-body">
                    <a name="<?php echo $comment['cid']; ?>"></a>
                    <div class="comment-author vcard">
        <?php if ($isGravatar == 'y'): ?><img src="<?php echo $comment['photo'] ? BLOG_URL . str_replace('../', '', $comment['photo']) : getGravatar($comment['mail']); ?>" class='avatar' height='40' width='40'  rel="nofollow"/><?php endif; ?>
                        <div class="floor"></div>
                        <strong><?php echo $comment['poster']; ?></strong>:</div>
                    <p><?php echo $comment['content'] = preg_replace("/\[(([1-4]?[0-9])|50)\]/", '<img src="' . TEMPLATE_URL . 'images/' . 'face/$1.gif" width="40" height="40" alt="faces">', $comment['content']); ?></p>
                    <div class="clear"></div><span class="datetime"><?php echo $comment['date']; ?></span>
        <?php if ($comment['level'] < 4): ?><span class="reply"><a class="comment-reply-link" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">[回复]</a></span><?php endif; ?>
                </div>
        <?php blog_comments_children($comments, $comment['children']); ?>
            </li></ul>
                        <?php endforeach; ?>
                    <?php } ?>
<?php

//blog：发表评论表单
function blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) {
    if ($allow_remark == 'y'):
        ?>
        <div id="comment-place">
            <div class="comment-post" id="comment-post">
                <div id="reply_state_box">&nbsp;</div>
                <div id="respond_box">
                    <div id="respond">
                        <h3>发表评论</h3>	

                        <div class="cancel-comment-reply">
                            <div id="real-avatar">
        <?php if (ROLE == 'visitor'): ?>
                                    <img src="<?php echo getGravatar($ckmail); ?>" class='avatar photo avatar-default' height='40' width='40' name="gravarimg"/>
        <?php else: ?>
            <?php global $CACHE;
            $user_cache = $CACHE->readCache('user');
            ?>
                                    <img src="<?php echo $user_cache[UID]['photo']['src'] ? BLOG_URL . $user_cache[UID]['photo']['src'] : getGravatar($user_cache[UID]['mail']); ?>" class='avatar photo avatar-default' height='40' width='40' />
        <?php endif; ?>			
                            </div>	

                            <div class="cancel-reply" id="cancel-reply" style="display:none"><a rel="nofollow" href="javascript:void(0);" onclick="cancelReply()">点击这里取消回复。</a></div>
                        </div>


                        <p class="comment-header"><a name="respond"></a></p>
                        <form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
                            <input type="hidden" name="gid" value="<?php echo $logid; ?>" id="comgid"/>
        <?php if (ROLE == 'visitor'): ?>
                                <div id="comment-author-info">
                                    <p>
                                        <input type="text" name="comname" id="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1">
                                        <label for="author">昵称</label>
                                    </p>
                                    <p>
                                    <div  class="autodiv_box">
                                        <a class="clear_email" href="javascript:;" node-type="clear" id="clear_email" title="email">×</a> <div id="auto-show">&nbsp;</div> </div><input type="text" name="commail"  id="commail" class="commail" onblur="gravatarimg()"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2"> 
                                        <label for="email">邮箱</label>
                                    
                                    </p>
                                    <p>
                                        <input type="text" name="comurl"  id="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
                                        <label for="url">网址</label>
                                    </p>
                                </div>
        <?php else: ?>

                                <div class="author">欢迎回来 <strong><?php echo $user_cache[UID]['name']; ?></strong>	
                                    <a href="<?php echo BLOG_URL; ?>admin/?action=logout" id="toggle-comment-author-info">[ 退出 ]</a>
                                </div>
        <?php endif; ?>
                            <div class="clear"></div>
                            <p id="face_box"><?php include View::getView('includes/smiley'); ?></p>
                            <p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
                            <p><?php echo $verifyCode; ?> <input type="submit" id="submit" value="发表评论" tabindex="6"  onClick="return commentSubmit();"/></p>

                            <input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
<?php } ?>
