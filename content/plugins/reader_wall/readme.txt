1.如果从4.1.0及之前版升级，请在覆盖前禁用插件，然后再覆盖文件后期用插件；

2.如果已经在未禁用之前覆盖了文件，那么请打开模板目录的page.php和echo_log.php，找到“doAction('xiaosong', $log_content)”，替换为“echo $log_content”，注意，两个文件都要修改，否则文章不能正确显示；

3.有问题请至http://xiaosong.org/guestbook留言。