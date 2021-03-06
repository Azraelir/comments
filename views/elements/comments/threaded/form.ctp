<?php
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$_url = array_merge($url, array('controller' => $this->params['controller'], 'action' => r(Configure::read('Routing.admin') . '_', '', $this->action)));
foreach (array('page', 'order', 'sort', 'direction') as $named) {
	if (isset($this->passedArgs[$named])) {
		$_url[$named] = $this->passedArgs[$named];
	}
}
if ($target) {
	$_url['action'] = r(Configure::read('Routing.admin') . '_', '', 'comments');
	$ajaxUrl = $commentWidget->prepareUrl(array_merge($_url, array('comment' => $comment, '#' => 'comment' . $comment)));
	echo $this->Form->create($modelName, array('url' => $ajaxUrl, 'target' => $target));
} else {
	echo $this->Form->create($modelName, array('url' => array_merge($_url, array('comment' => $comment, '#' => 'comment' . $comment))));
}
echo $this->Form->input('Comment.title');
echo $this->Form->input('Comment.body', array(
    'error' => array(
        'body_required' => __d('comments', 'This field cannot be left blank',true),
        'body_markup' => sprintf(__d('comments', 'You can use only headings from %s to %s' ,true), 4, 7))));
// Bots will very likely fill this fields
echo $this->Form->input('Other.title', array('type' => 'hidden'));
echo $this->Form->input('Other.comment', array('type' => 'hidden'));
echo $this->Form->input('Other.submit', array('type' => 'hidden'));

if ($target) {
	echo $js->submit(__d('comments', 'Submit', true), array_merge(array('url' => $ajaxUrl), $commentWidget->globalParams['ajaxOptions']));
} else {
	echo $this->Form->submit(__d('comments', 'Submit', true));
}
echo $this->Form->end();

