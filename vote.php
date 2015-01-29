<?php
require_once('inc/class.Strawpoll.php');
set_time_limit(0);

if($argc < 3) {
    echo "Usage: php vote.php <VoteID> <Option> <Amount>\n";
}
else {
    $id     = $argv[1];
    $option = $argv[2] - 1;
    $amount = $argv[3];
    $sp = new StrawPoll();
    $votes = $sp->vote($id, $option, $amount, 'proxies.txt');
    echo 'Successfully voted ' . $votes['votes'] . '/' . $votes['total'] . ' time(s)' . "\n";

}


