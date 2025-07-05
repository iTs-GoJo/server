<?php
// ﴾ ! @Sourrce_Kade ! ﴿ // اسکی با زدن منبع آزاد //
error_reporting(E_ALL);
ini_set('display_errors','1');
ini_set('memory_limit' , '-1');
ini_set('max_execution_time','0');
ini_set('display_startup_errors','1');
date_default_timezone_set('Asia/Tehran');

if(!file_exists('madeline.php')){
copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
if(!is_dir('files')){
mkdir('files');
}
if(!file_exists('madeline.php')){
copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
if(!file_exists('online.txt')){
file_put_contents('online.txt','off');
}
if(!file_exists('timebio.txt')){
file_put_contents('timebio.txt','off');
}
if(!file_exists('part.txt')){
file_put_contents('part.txt','off');
}
if(!file_exists('data.json')){
file_put_contents('data.json', '{"power":"on","adminStep":"","typing":"off","tag":"off","echo":"off","markread":"off","poker":"off","enemies":[],"answering":[]}');
}
include 'madeline.php';

use \danog\MadelineProto\API;
use \danog\Loop\Generic\GenericLoop;
use \danog\MadelineProto\EventHandler;
use \danog\MadelineProto\Shutdown;

class XHandler extends EventHandler
{
    const Admins = [];
    const Report = '';
    
    public function getReportPeers()
    {
        return [self::Report];
}
    
    public function genLoop()
    {
if(file_get_contents('online.txt') == 'on'){
yield $this->account->updateStatus(['offline' => false]);
}
if(file_get_contents('timebio.txt') == 'on'){
$time = date("H:i");
yield $this->account->updateProfile(['about' => "Join Channel : @SlowTM & @SlowChannel | $time"]);
}
return 60000;
}
    
    public function onStart()
    {
 $genLoop = new GenericLoop([$this, 'genLoop'], 'update Status');
 $genLoop->start();
}
    
    public function onUpdateNewChannelMessage($update)
    {
yield $this->onUpdateNewMessage($update);
}
    
    public function onUpdateNewMessage($update)
    {
if(time() -$update['message']['date'] > 2){
            return;
}
        try {
if((isset($update['message']['message']) ?? null)){
$replyToId = $update['message']['reply_to']['reply_to_msg_id'] ?? 0;
$text = $update['message']['message'] ?? null;
$fromId = $update['message']['from_id']['user_id'] ?? 0;
$msg_id = $update['message']['id'] ?? 0;
$message = $update['message'] ?? null;
$me = yield $this->getSelf();
$me_id = $me['id'];
$Gets = yield $this->getInfo($update);
$peer = yield $this->getID($update);
$type3 = $Gets['type'];
$data = json_decode(file_get_contents("data.json"), true);
$step = $data['adminStep'];
if((in_array($fromId, self::Admins)) or $fromId == $me_id){
if(preg_match("/^[\/\#\!]?(bot) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(bot) (on|off)$/i",$text,$m);
$data['power'] = $m[2];
file_put_contents("data.json", json_encode($data));
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "روشن شدم 👇♻️$m[2]"]);
}
if(preg_match("/^[\/\#\!]?(online) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(online) (on|off)$/i",$text,$m);
file_put_contents('online.txt',$m[2]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "انلاین میمانم 🔋 $m[2]"]);
}
if($text == 'timebio on' or $text == 'Timebio on'){
file_put_contents('timebio.txt','on');
$this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⏰Time the name was successfully on']);
}
if($text == 'timebio off' or $text == 'Timebio off'){
file_put_contents('timebio.txt','off');
$this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⏰Time the name was successfully off']);
}
if($text == 'پینگ' or $text == 'ping'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "𝑩𝑶𝑻 𝑰𝑺 𝑶𝑵𝑳𝑰𝑵𝑬 :)"]);
}
if($text == 'پیکربندی' or $text == 'confing'){
yield $this->channels->joinChannel(['channel' => '@SlowTM']);
yield $this->channels->joinChannel(['channel' => '@SlowChannel']);
yield $this->channels->joinChannel(['channel' => '@TKPHP']);
yield $this->messages->sendMessage(['peer' => '@SlowFinderBot','message'         => '/start']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Confing is OK !"]);
}
if($text == '/restart'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🗂 𝑻𝑯𝑬 𝑹𝑶𝑩𝑶𝑻 𝑾𝑨𝑺 𝑺𝑼𝑪𝑪𝑬𝑺𝑺𝑭𝑼𝑳𝑳𝒀 𝑹𝑬𝑺𝑻𝑨𝑹𝑻𝑬𝑫."]);
 $this->restart();
}
if($text == 'مصرف' or $text == 'وضعیت' or $text == 'status'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "𝑴𝑬𝑴𝑶𝑹𝒀 𝑼𝑺𝑰𝑵𝑮 : $mem_using"]);
}
if($text == 'اژدر' or $text == 'bot' or $text == 'ربات' or $text == ' Robot' or $text == 'رباا' or $text == 'bot' or $text == 'Bot'){
$this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "بنال😁"]);
}
if($text == '/proxy' or $text == 'پروکسی' or $text == 'پروکسی میخوام' or $text == 'proxy bde' or $text == 'prox' or $text == 'پروکس' or $text == 'پروکصی'){
$this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "𝑭𝒓𝒆𝒆 𝑷𝒓𝒐𝒙𝒚 𝑭𝒐𝒓 𝑻𝒆𝒍𝒆𝒈𝒓𝒂𝒎🤝
<┈┅┅━━━✦━━━┅┅┈>  
http://api.codebazan.ir/mtproto/?type=html&channel=ProxyMTProto
<┈┅┅━━━✦━━━┅┅┈>"]);
}
if($text == 'لامپ' or $text == 'نور' or $text == 'چراغ' or $text == 'light'){
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡              ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡             ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡            ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡           ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡          ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡         ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡        ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡       ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡      ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡     ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡    ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡   ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡  ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡 ⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡⚡️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '💡']);
}
if($text == 'نامه' or $text == 'صندوق' or $text == 'پست' or $text == 'mail'){
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫               ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫              ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫             ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫            ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫           ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫          ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫         ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫        ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫       ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫      ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫     ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫    ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫   ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫  ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫 ✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📫✉️']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '📬']);
}
if($text == 'نویسنده' or $text == 'سازنده'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => ".
🔥🔥🔥🔥🔥🔥🔥🔥
🔥🔥🔥🔥🔥🔥🔥🔥
               🔥🔥
               🔥🔥
               🔥🔥
               🔥🔥
               🔥🔥
               🔥🔥
               🔥🔥
               🔥🔥"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => ".
❣❣                              ❣❣❣
❣❣❣                      ❣❣❣
❣❣❣❣            ❣❣❣
❣❣    ❣❣    ❣❣    
❣❣        ❣❣❣❣
❣❣           ❣❣❣❣
❣❣                 ❣❣❣❣
❣❣                       ❣❣❣❣
❣❣                         ❣❣❣❣
❣❣                            ❣❣❣❣"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => ".
💞💞💞💞💞💞💞
💞💞💞💞💞💞💞                    
💞💞               💞💞
💞💞               💞💞
💞💞💞💞💞💞💞           
💞💞💞💞💞💞💞                  
💞💞                             
💞💞                             
💞💞                             
💞💞                       "]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => " .
♥♥                          ♥♥
♥♥                          ♥♥
♥♥                          ♥♥
♥♥                          ♥♥
♥♥♥♥♥♥♥♥♥
♥♥♥♥♥♥♥♥♥
♥♥                          ♥♥
♥♥                          ♥♥
♥♥                          ♥♥
♥♥                          ♥♥
"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => ".
💞💞💞💞💞💞💞
💞💞💞💞💞💞💞                    
💞💞               💞💞
💞💞               💞💞
💞💞💞💞💞💞💞           
💞💞💞💞💞💞💞                  
💞💞                             
💞💞                             
💞💞                             
💞💞                       "]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "@TK 💜"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "@TKP 💙"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "@TKPH 💚"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "@TKPHP‌ 💛 𝙵𝙸𝙽𝙸𝚂𝙷𝙴𝙳 🤯 "]);
sleep(1);
}

if($text== 'پول' or $text == 'دلار'  or $text == 'ارباب شهر من'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌                    💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌                   💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌                 💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌                💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌               💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌              💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌             💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌            💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌           💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌          💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥                     💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌        💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌       💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌      💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌     💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌    💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌   💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌  💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌ 💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥            ‌💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥           💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥          💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥         💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥        💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥       💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥      💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥     💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥    💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥   💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥  💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔥 💵']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '💸']);

}
if($text == 'سردار' or $text == 'سلیمانی'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '

⣿⣿⣿⣿⣿⠿⠯⠉⠉⠏⠛⢿⣿⣿⡿⠛⠹⠉⠉⠉⠛⢿⣿⣿⣿
⣿⣿⡿⢋⣴⣶⣿⣿⣿⣷⣶⣄⠈⢁⣠⣶⣿⣿⣿⣷⣤⡀⠉⠻⣿
⣿⡟⢡⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⡄⣽
⣿⠇⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢸
⣿⡟⣿⣿⣿⣿⣿⣿⣿⠀⣿⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢸
⣿⣧⢻⣿⣿⣿⣿⡿⢈⠀⡿⠦⠈⣿⡏⠘⠋⠙⠙⠉⣿⣿⣿⡏⣾
⣿⣿⣆⢻⣿⣿⡋⣠⣾⣷⣷⣶⣾⠋⣡⣶⣾⣷⣷⣿⣿⣿⠏⣼⣿
⣿⣿⣿⣆⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡟⠋⣴⣿⣿
⣿⣿⣿⣿⣧⡀⠈⠛⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠋⣰⣾⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣦⡀⠀⠙⢿⣿⣿⣿⣿⣿⠟⢃⣴⣾⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣶⣄⠀⠙⠿⠟⠋⣀⣴⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣦⣤⣴⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
']);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '

⣿⣿⣿⣿⣿⣿⣿⣿⠿⠟⠉⠭⠙⠛⠙⠛⢿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⡿⠟⠑⠙⠀⠀⠀⢀⢀⠉⠀⠀⠍⠉⠙⠻⣿⣿⣿⣿⣿⣿
⣿⣿⠏⠆⠂⠀⠀⠀⠀⠀⠀⠉⠑⠰⢂⣶⣖⠀⠀⠙⢿⣿⣿⣿⣿
⣿⡗⠀⢠⣶⣶⣾⣿⣿⣯⠀⢤⣺⣻⣥⢾⡈⠂⠀⠀⠀⣼⣿⣿⣿
⣿⡇⠀⡀⠿⠛⣿⣿⣿⣿⣾⠘⢻⣿⠃⠀⠀⠀⠀⠀⠀⠈⣿⣿⣿
⣿⣇⠀⠀⠀⠀⠀⠉⠋⠉⠙⠋⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿
⣿⣿⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠜⠉⣿⣿
⣿⣿⣶⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣀⡀⠀⠀⠀⠐⠖⣿⣿
⣿⣿⣿⣧⠀⡄⠐⠀⠀⠀⠀⠀⠀⣤⣾⣿⣿⣿⠷⠀⠀⠀⠃⣿⣿
⣿⣿⣿⣿⣧⠹⣿⣿⣿⣿⣿⠀⠈⠻⣿⡯⠟⠃⠀⠀⠀⠀⢠⣿⣿
⣿⣿⣿⣿⣿⣆⠈⠙⠇⠈⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿
⣿⣿⣿⣿⣿⣿⡖⠂⠀⠀⡴⠀⠀⠀⠈⠦⡀⠀⠀⢀⣾⠀⢸⣿⣿
⣿⣿⣿⣿⣿⣿⡶⣾⠀⣰⡧⣦⣤⣴⡿⡀⢈⢷⡢⡿⠁⠀⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⢿⣿⣵⣿⠿⣿⣟⣛⣻⣿⣮⣽⣄⣾⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠞⢻⠻⠟⠛⠻⠏⠈⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⣤⠀⠀⠀⠀⢀⣠⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
']);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
⣿⣿⣿⡿⢛⠫⠩⠉⠉⠉⠛⠿⣿⣿⠿⠛⠉⠉⠉⠉⠙⠿⣿⣿⣿
⣿⣿⡯⢊⣤⣶⣿⣿⣿⣷⣦⣄⠀⠀⣠⣶⣾⣿⣿⣷⣄⡀⠀⠹⣿
⣿⡏⢡⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⣿⣿⣿⣿⣿⣷⡄⢼
⣿⠇⣿⡏⠈⣿⣿⠻⣿⣿⣿⣿⣿⣿⣿⣿⡁⢸⣿⣿⣿⢿⣿⣿⢸
⣿⡟⣿⣿⠀⣿⡟⠀⠈⢻⣿⣿⣿⣿⠿⣿⣇⠸⣿⣿⣇⠀⢿⣿⢸
⣿⣧⢻⣿⠀⠛⠁⠈⠐⠀⣿⣿⣿⡏⢰⣿⣿⠀⣿⠙⠛⠂⢸⡏⣾
⣿⣿⣆⢻⣷⣶⣶⣶⣶⣴⣿⣿⣿⡇⠈⠉⠁⢠⣿⣶⣶⡶⠎⣼⣿
⣿⣿⣿⣆⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿⣶⣶⣾⣿⣿⣿⠟⠁⣴⣿⣿
⣿⣿⣿⣿⣦⡀⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠉⣰⣾⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣦⡀⠀⠙⢿⣿⣿⣿⣿⣿⠟⢃⣴⣾⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣶⣄⠀⠙⠿⠟⠋⣀⣴⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣦⣤⣴⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
']);
}
if($text == 'بخند کیر نشه' or $text == 'بخند'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😐😂😐😂😐😂😐
😂        👇🏻           😂
😐         👇🏻          😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐          👆🏻          😐
😂          👆🏻          😂
😐 😂😐😂😐😂😐']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
😂😐😂😐😂😐😂
😐        👇🏿           😐
😂         👇🏿          😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂          👆🏿          😂
😐          👆🏿          😐
😂 😐😂😐😂😐😂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => 'خندیدیم بمولا 😐']);
}

if($text == 'ریدیم' or $text == 'biu'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
💩
                        
                        
                        
                        
                        
                        
                        
                        
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
💩
                        
                        
                        
                        
                        
                        
                        
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
                        
💩
                        
                        
                        
                        
                        
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
                        
                        
💩
                        
                        
                        
                        
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
                        
                        
                        
💩
                        
                        
                        
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
                        
                        
                        
                        
                        
💩
                        
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
                        
                        
                        
                        
                        
                        
💩
                        
🧑‍🦯']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐒
                        
                        
                        
                        
                        
                        
                        
                        
💩
🧑‍🦯']);
}
if($text == '/bk' or $text == 'بکیرم'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤤🤤🤤
🤤         🤤
🤤           🤤
🤤        🤤
🤤🤤🤤
🤤         🤤
🤤           🤤
🤤           🤤
🤤        🤤
🤤🤤🤤
"]);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "
😂         😂
😂       😂
😂     😂
😂   😂
😂😂
😂   😂
😂      😂
😂        😂
😂          😂
😂            😂"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💋💋💋          💋         💋
💋         💋      💋       💋
😏           😏    😏     😏
😏        😏       😏   😏
😄😄😄          😄😄
😃         😄      😄   😄
🤘           🤘    🤘      🤘
🤘           🤘    🤘        🤘
🙊       🙊        🙊          🙊
🙊🙊🙊          🙊            🙊"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💋💋💋          💋         💋
😏         😏      😏       😏
😏           😏    😏     😏
😄        😄       😄   😄
😄😄😄          😄😄
🤘         🤘      🤘   🤘
🤘           🤘    🤘      🤘
🙊           🙊    🙊        🙊
🙊       🙊        🙊          🙊
💋💋💋          💋            💋"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😏😏😏          😏         😏
😏         😏      😏       😏
😄           😄    😄     😄
😄        😄       😄   😄
🤘🤘🤘          🤘🤘
🤘         🤘      🤘   🤘
🙊           🙊    🙊      🙊
🙊           🙊    🙊        🙊
💋       💋        💋          💋
💋💋💋          💋            💋"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😏😏😏          😏         😏
😄         😄      😄       😄
😄           😄    😄     😄
🤘        🤘       🤘   🤘
🤘🤘🤘          🤘🤘
🙊         🙊      🙊   🙊
🙊           🙊    🙊      🙊
💋           💋    💋        💋
💋       💋        💋          💋
😏😏😏          😏            😏"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😄😄😄          😄         😄
😄         😄      😄       😄
🤘           🤘    🤘     🤘
🤘        🤘       🤘   🤘
🙊🙊🙊          🙊🙊
🙊         🙊      🙊   🙊
💋           💋    💋      💋
💋           💋    💋        💋
😏       😏        😏          😏
😏😏😏          😏            😏
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😄😄😄          😄         😄
🤘         🤘      🤘       🤘
🤘           🤘    🤘     🤘
🙊        🙊       🙊   🙊
🙊🙊🙊          🙊🙊
💋         💋      💋   💋
💋           💋    💋      💋
😏           😏    😏        😏
😏       😏        😏          😏
😄😄😄          😄            😄
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤘🤘🤘          🤘         🤘
🤘         🤘      🤘       🤘
🙊           🙊    🙊     🙊
🙊        🙊       🙊   🙊
💋💋💋          💋💋
💋         💋      💋   💋
😏           😏    😏      😏
😏           😏    😏        😏
😄       😄        😄          😄
😄😄😄          😄            😄
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤘🤘🤘          🤘         🤘
🙊         🙊      🙊       🙊
🙊           🙊    🙊     🙊
💋        💋       💋   💋
💋💋💋          💋💋
😏         😏      😏   😏
😏           😏    😏      😏
😄           😄    😄        😄
😄       😄        😄          😄
🤘🤘🤘          🤘            🤘
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🙊🙊🙊          🙊         🙊
🙊         🙊      🙊       🙊
💋           💋    💋     💋
💋        💋       💋   💋
😏😏😏          😏😏
😏         😏      😏   😏
😄           😄    😄      😄
😄           😄    😄        😄
🤘       🤘        🤘          🤘
🤘🤘🤘          🤘            🤘
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🙊🙊🙊          💋         🙊
💋         💋      💋       💋
💋           💋    💋     💋
😏        😏       😏   😏
😏😏😏          😏😏
😄         😄      😄   😄
😄           😄    😄      😄
🤘           🤘    🤘        🤘
🤘       🤘        🤘          🤘
🙊🙊🙊          🙊            🙊
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💋💋💋          💋         💋
💋         💋      💋       💋
😏           😏    😏     😏
😏        😏       😏   😏
😄😄😄          😄😄
😄         😄      😄   😄
🤘           🤘    🤘      🤘
🤘           🤘    🤘        🤘
🙊       🙊        🙊          🙊
🙊🙊🙊          🙊            🙊
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💋💋💋          💋         💋
😏         😏      😏       😏
😏           😏    😏     😏
😄        😄       😄   😄
😄😄😄          😄😄
🤘         🤘      🤘   🤘
🤘           🤘    🤘      🤘
🙊           🙊    🙊        🙊
🙊       🙊        🙊          🙊
💋💋💋          💋            💋
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😏😏😏          😏         😏
😏         😏      😏       😏
😄           😄    😄     😄
😄        😄       😄   😄
🤘🤘🤘          🤘🤘
🤘         🤘      🤘   🤘
🙊           🙊    🙊      🙊
🙊           🙊    🙊        🙊
💋       💋        💋          💋
💋💋💋          💋            💋
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😏😏😏          😏         😏
😄         😄      😄       😄
😄           😄    😄     😄
🤘        🤘       🤘   🤘
🤘🤘🤘          🤘🤘
🙊         🙊      🙊   🙊
🙊           🙊    🙊      🙊
💋           💋    💋        💋
💋       💋        💋          💋
😏😏😏          😏            😏
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😄😄😄          😄         😄
😄         😄      😄       😄
🤘           🤘    🤘     🤘
🤘        🤘       🤘   🤘
🙊🙊🙊          🙊🙊
🙊         🙊      🙊   🙊
💋           💋    💋      💋
💋           💋    💋        💋
😏       😏        😏          😏
😏😏😏          😏            😏
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😄😄😄          😄         😄
🤘         🤘      🤘       🤘
🤘           🤘    🤘     🤘
🙊        🙊       🙊   🙊
🙊🙊🙊          🙊🙊
💋         💋      💋   💋
💋           💋    💋      💋
😏           😏    😏        😏
😏       😏        😏          😏
😄😄😄          😄            😄
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤘🤘🤘          🤘         🤘
🤘         🤘      🤘       🤘
🙊           🙊    🙊     🙊
🙊        🙊       🙊   🙊
💋💋💋          💋💋
💋         💋      💋   💋
😏           😏    😏      😏
😏           😏    😏        😏
😄       😄        😄          😄
😄😄😄          😄            😄
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤘🤘🤘          🤘         🤘
🙊         🙊      🙊       🙊
🙊           🙊    🙊     🙊
💋        💋       💋   💋
💋💋💋          💋💋
😏         😏      😏   😏
😏           😏    😏      😏
😄           😄    😄        😄
😄       😄        😄          😄
🤘🤘🤘          🤘            🤘
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🙊🙊🙊          🙊         🙊
🙊         🙊      🙊       🙊
💋           💋    💋     💋
💋        💋       💋   💋
😏😏😏          😏😏
😏         😏      😏   😏
😄           😄    😄      😄
😄           😄    😄        😄
🤘       🤘        🤘          🤘
🤘🤘🤘          🤘            🤘
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🙊🙊🙊          🙊         🙊
💋         💋      💋       💋
💋           💋    💋     💋
😏        😏       😏   😏
😏😏😏          😏😏
😄         😄      😄   😄
😄           😄    😄      😄
🤘           🤘    🤘        🤘
🤘       🤘        🤘          🤘
🙊🙊🙊          🙊            🙊
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💋💋💋          💋         💋
💋         💋      💋       💋
😏           😏    😏     😏
😏        😏       😏   😏
😄😄😄          😄😄
😄         😄      😄   😄
🤘           🤘    🤘      🤘
🤘           🤘    🤘        🤘
🙊       🙊        🙊          🙊
🙊🙊🙊          🙊            🙊
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💋💋💋          💋         💋
😏         😏      😏       😏
😏           😏    😏     😏
😄        😄       😄   😄
😄😄😄          😄😄
🤘         🤘      🤘   🤘
🤘           🤘    🤘      🤘
🙊           🙊    🙊        🙊
🙊       🙊        🙊          🙊
💋💋💋          💋            💋
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😏😏😏          😏         😏
😏         😏      😏       😏
😄           😄    😄     😄
😄        😄       😄   😄
🤘🤘🤘          🤘🤘
🤘         🤘      🤘   🤘
🙊           🙊    🙊      🙊
🙊           🙊    🙊        🙊
💋       💋        💋          💋
💋💋💋          💋            💋
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😏😏😏          😏         😏
😄         😄      😄       😄
😄           😄    😄     😄
🤘        🤘       🤘   🤘
🤘🤘🤘          🤘🤘
🙊         🙊      🙊   🙊
🙊           🙊    🙊      🙊
💋           💋    💋        💋
💋       💋        💋          💋
😏😏😏          😏            😏
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😄😄😄          😄         😄
😄         😄      😄       😄
🤘           🤘    🤘     🤘
🤘        🤘       🤘   🤘
🙊🙊🙊          🙊🙊
🙊         🙊      🙊   🙊
💋           💋    💋      💋
💋           💋    💋        💋
😏       😏        😏          😏
😏😏😏          😏            😏
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😄😄😄          😄         😄
🤘         🤘      🤘       🤘
🤘           🤘    🤘     🤘
🙊        🙊       🙊   🙊
🙊🙊🙊          🙊🙊
💋         💋      💋   💋
💋           💋    💋      💋
😏           😏    😏        😏
😏       😏        😏          😏
😄😄😄          😄            😄
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤘🤘🤘          🤘         🤘
🤘         🤘      🤘       🤘
🙊           🙊    🙊     🙊
🙊        🙊       🙊   🙊
💋💋💋          💋💋
💋         💋      💋   💋
😏           😏    😏      😏
😏           😏    😏        😏
😄       😄        😄          😄
😄😄😄          😄            😄
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤘🤘🤘          🤘         🤘
🙊         🙊      🙊       🙊
🙊           🙊    🙊     🙊
💋        💋       💋   💋
💋💋💋          💋💋
😏         😏      😏   😏
😏           😏    😏      😏
😄           😄    😄        😄
😄       😄        😄          😄
🤘🤘🤘          🤘            🤘
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🙊🙊🙊          🙊         🙊
🙊         🙊      🙊       🙊
💋           💋    💋     💋
💋        💋       💋   💋
😏😏😏          😏😏
😏         😏      😏   😏
😄           😄    😄      😄
😄           😄    😄        😄
🤘       🤘        🤘          🤘
🤘🤘🤘          🤘            🤘
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤬🤬🤬          🤬         🤬
😡         😡      😡       😡
🤬           🤬    🤬     🤬
😡        😡       😡   😡
🤬🤬🤬          🤬🤬
😡         😡      😡   😡
🤬           🤬    🤬      🤬
😡           😡    😡        😡
🤬       🤬        🤬          🤬
😡😡😡          😡            😡
"]);
 
}

if($text == 'رقصص' or $text == 'دنسس'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥
🟥🔲🔳🔲🟥
🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥
🟥🟥🔲🟥🟥
🟥🟥🔳🟥🟥
🟥🟥🔲🟥🟥
🟥🟥🟥🟥🟥']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥
🟥🟥🟥🔲🟥
🟥🟥🔳🟥🟥
🟥🔲🟥🟥🟥
🟥🟥🟥🟥🟥']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥
🟥🔲🟥🟥🟥
🟥🟥🔳🟥🟥
🟥🟥🟥🔲🟥
🟥🟥🟥🟥🟥']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟪🟪🟪🟪🟪
🟪🟪🟪🟪🟪
🟪🔲🔳🔲🟪
🟪🟪🟪🟪🟪
🟪🟪🟪🟪🟪']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟪🟪🟪🟪🟪
🟪🟪🔲🟪🟪
🟪🟪🔳🟪🟪
🟪🟪🔲🟪🟪
🟪🟪🟪🟪🟪']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟪🟪🟪🟪🟪
🟪🟪🟪🔲🟪
🟪🟪🔳🟪🟪
🟪🔲🟪🟪🟪
🟪🟪🟪🟪🟪']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟪🟪🟪🟪🟪
🟪🔲🟪🟪🟪
🟪🟪🔳🟪🟪
🟪🟪🟪🔲🟪
🟪🟪🟪🟪🟪']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟦🟦🟦🟦🟦
🟦🟦🟦🟦🟦
🟦🔲🔳🔲🟦
🟦🟦🟦🟦🟦
🟦🟦🟦🟦🟦']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟦🟦🟦🟦🟦
🟦🟦🔲🟦🟦
🟦🟦🔳🟦🟦
🟦🟦🔲🟦🟦
🟦🟦🟦🟦🟦']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟦🟦🟦🟦🟦
🟦🟦🟦🔲🟦
🟦🟦🔳🟦🟦
🟦🔲🟦🟦🟦
🟦🟦🟦🟦🟦']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟦🟦🟦🟦🟦
🟦🔲🟦🟦🟦
🟦🟦🔳🟦🟦
🟦🟦🟦🔲🟦
🟦🟦🟦🟦🟦']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '◻️🟩🟩◻️◻️
◻️◻️🟩◻️🟩
🟩🟩🔳🟩🟩
🟩◻️🟩◻️◻️
◻️◻️🟩🟩◻️']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟩⬜️⬜️🟩🟩
🟩🟩⬜️🟩⬜️
⬜️⬜️🔲⬜️⬜️
⬜️🟩⬜️🟩🟩
🟩🟩⬜️⬜️🟩']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️']);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '☘تـــــــــــــــامـــــــــــام☘']);

}
if($text == 'مرغ' or $text == 'جوجه'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــــــــــ 🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ــ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🥚ـ🐓']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🐣']);

}
if($text == 'قلبز' or $text == '/ghalb'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "❤️"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🧡"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💛"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💚"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💙"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💜"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🖤"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🤍"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🤎"]);
sleep(1);
}
if($text == 'زندگی' or $text == '/SN'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😌"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "😍"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "😘"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🧡"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💚"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💙"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🤍"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "🤎"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "❤️"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "💔"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "😕"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "😢"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "😭"]);
sleep(2);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id,'message' => "😔"]);
sleep(2);
}
if($text == 'حلقه' or $text == 'halg'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚_____________💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚____________💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚___________💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚_________💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚_______💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚_____💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚____💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚__💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚_💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤚💍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💏"]);
}

if($text == 'بوص' or $text == 'kiss'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💙🧡💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍💙💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💙
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     💙
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💜💙
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💙🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
💙💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💙     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💙🧡💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍💙💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💙
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     💙
❤️💜🤎
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💜💙
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💙🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
💙💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💙     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💙🧡💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍💙💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💙
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     💙
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💜💙
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💙🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     💟
💙💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💙     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
💙🧡💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍💙💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💙
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💜🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💜💙
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
❤️💙🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🤍🧡💛
💚     🤎
💙❤️🖤
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️💙🧡
🤎 ♡🤍
🖤💜💚
"]);

}
if($text == 'صیک' or $text == 'sik'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤
🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️🖤❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕
🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿
🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕
🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿
🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕
🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿
🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕🖕
🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿
"]);

}
if($text == 'قلب' or $text == 'Lyt'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💚💚💚💚💚"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💛💛💛💛💛"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "❤️❤️❤️❤️❤️"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💙💙💙💙💙"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🧡🧡🧡🧡🧡"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💛💛💛💛💛"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤍🤍🤍🤍🤍"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤎🤎🤎🤎🤎"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💓💓💓💓💓"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💟💟💟💟💟"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💘💘💘💘💘"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💖💖💖💖💖"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💞💞💞💞💞"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💝💝💝💝💝"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💕💕💕💕💕"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💗💗💗💗💗"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "❣️❣️❣️❣️❣️"]);
	
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "قلباهمشون براتو💜😉"
]);
} 
if($text == 'کیرم' or $text == 'kirme'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦___________𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦__________𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦________𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦______𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦____𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦__𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦_𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💦𓂸"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "𓂺"]);
}
if($text == 'گوه خور' or $text == 'gohbo'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩💩💩
💩💩💩
🖕🖕🖕🖕💩💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂💩🖕
🖕😐🖕
 😂🖕😂
💩💩💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😐💩😐
💩😂🖕
💥💩💥
🖕🖕😐"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤤🖕😐
😏🖕😏
💩💥💩
💩🖕😂"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩💩💩
🤤🤤🤤
💩👽💩
💩😐💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😐🖕💩
💩💥💩
💩🖕💩
💩💔😐"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩💩🖕💩
😐🖕😐🖕
💩🤤🖕🤤
🖕😐💥💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💥😐🖕💥
💥💩💩💥
👙👙💩💥
💩💔💩👙"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩👙💥🖕
💩💥🖕💩
👙💥🖕💥
💩😐👙🖕
💥💩💥💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩😐🖕💩
💩🖕💥
👙🖕💥
👙🖕💥
💩💥🖕
😂👙🖕
💩💥👙"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤤😂🖕👙
😏🖕💥👙🖕🖕
😂🖕👙💥😂🖕
😂🖕👙🖕😂🖕
💔🖕🖕🖕🖕🖕
💩💩💩💩
💩👙💩👙"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤫👙💩😂
💩🖕💩👙💥💥
💩💩💩💩💩💩
💩😐💩😐💩😐
😃💩😃😃💩😃
🤤💩🤤💩🤤💩
💩👙💩😐🖕💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩🖕💥👙💥
💩👙💥🖕💥👙
👙🖕💥💩💩💥
👙🖕💥💩💥😂
💩💥👙🖕💩🖕
💩👙💥🖕💥😂
💩👙💥🖕"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩👙💥👙👙
💩👙💥🖕💩😂
💩👙💥🖕💥👙
💩👙💥🖕💩👙
💩👙💥🖕😂😂
💩👙💥🖕😂😂
💩👙💥🖕"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💩💩💩💩💩"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "|
خـــــــوردــــــــــی
نـــــــــــــوــــــــش|
"]);
} 
if($text == 'شکست عشقی' or $text == 'ops'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔____________❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔__________❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔________❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔_____❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔___❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔_❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "💔❤"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🥺"]);
}
if($text == 'عاشق' or $text == 'galbam'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😊"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😙"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😚"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "☺"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤗"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😘"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😍"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🥰"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "❤"]);
}
if($text == 'ناراحت' or $text == 'gamgin'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🙁"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "☹"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😟"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🥺"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😔"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😪"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😢"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😥"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😫"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😭"]);
}
if($text == 'لبخند' or $text == 'hapi'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🙂"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😊"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😁"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😄"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😃"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😀"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😆"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😅"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂"]);
sleep(1);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤣"]);
}
if($text == 'کییر' or $text == 'kir'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁']);


yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
 .                                                               😁
                                                            😁
                                                        😁','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
 .                                                               😁
                                                            😁
                                                        😁
                                                    😬','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
 .                                                               😁
                                                            😁
                                                        😁
                                                    😬
                                                       😁','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                                                       😁
                                                          😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                     😬
                                                        😁
                                                     😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '.                                                               😁
                                                            😁
                                                        😁
                                                     😬
                                                        😁
                                               😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '.                                                               😁
                                                            😁
                                                        😁
                                                     😬
                                                         😁
                                           😁😁😁😐','id' =>
$msg_id ]);
sleep(0.5);                     
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                                                       😁
                                    😁😁😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                     😬
                                                         😁
                                😁😁😁😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '.                                                               😁
                                                            😁
                                                        😁
                                                     😬
                               😉                    😁
                               😁😁😁😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                    😁
                         😁😁😁😁😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
 .                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                   😁
                   😁😁😁😁😁😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
 .                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                   😁
              😩😁😁😁😁😁😁😁😐','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                    😁
              😩😁😁😁😁😁😁😁😐
         
                   🤣🤣','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                    😁
              😩😁😁😁😁😁😁😁😐
          😁 
                   🤣🤣','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                    😁
              😩😁😁😁😁😁😁😁😐
          😁 
       😁        🤣🤣','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
 .                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                    😁
              😩😁😁😁😁😁😁😁😐
          😁 
       😁        🤣🤣
    😁','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😁
                                                            😁
                                                        😁
                                                    😬
                              😉                    😁
              😩😁😁😁😁😁😁😁😐
          😁 
       😁        🤣🤣
    😁
😑','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               🤣
                                                            🤣
                                                        🤣
                                                    🤣
                              🤣                    🤣
              🤣🤣🤣🤣🤣🤣🤣🤣🤣
          🤣 
       🤣        🤣🤣
    🤣
🤣','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               🖕
                                                            🖕
                                                        🖕
                                                    🖕
                              🖕                    🖕
              🖕🖕🖕🖕🖕🖕🖕🖕🖕
          🖕 
       🖕        🤣🤣
    🖕
🖕','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😱
                                                            😱
                                                        😱
                                                    😱
                              😱                    😱
              😱😱😱😱😱😱😱😱😱
          😱 
       😱        😙😙
    😱
😱','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
.                                                               😭
                                                            😭
                                                        😭
                                                    😭
                              😭                    😭
              😭😭😭😭😭😭😭😭😭
          😭 
       😭        😩😩
    😭
😭','id' =>$msg_id ]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => ' بی ادف☹️','id' =>$msg_id ]);
 
}
if($text == 'خونشام' or $text == 'بیدارش کن'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــــــــــــ 🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ــ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⚰ـ🧟‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🧛‍♂']);
}

if($text == 'تله' or $text == 'گیرش بنداز'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                    ‌                    🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                                       🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                                     🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                                  🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                               🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                             🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                           🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                         🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                      🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                     🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                   🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                 🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼                🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼              🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼            🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼          🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼        🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼      🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼   🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼  🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸🌼 🦟']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🕸']);
}
if($text == 'موک' or $text == 'moc'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟪🟩🟨⬛️"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟧🟨🟩🟦"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟪🟦🟥🟩"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "⬜️⬛️⬜️🟪"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟨🟦⬜️🟩"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟥⬛️🟪🟦"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟧🟩🟫🟨"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🔳🔲◻️🟥"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "▪️▫️◽️◼️"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "◻️◼️◽️▪️"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟪🟦🟨🟪"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟥⬛️🟪🟩"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟧🟨🟥🟦"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟩🟦🟩🟪"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🔳🔲🟪🟥"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟧🟨🟩🟦"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟪🟦🟥🟩"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "⬜️⬛️⬜️🟪"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟨🟦🟪🟩"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟥⬛️🟪🟦"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟧🟩🟫🟨"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🔳🔲◻️🟥"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "▪️▫️◽️◼️"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "◻️◼️◽️▪️"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟪🟦🟨🟪"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟥⬛️🟪🟩"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟧🟨🟥🟦"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🟩🟦🟩🟪"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🔳🔲🟪🟥"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "☘❤💜💚☘"
]);
}
if($text == 'کتاب' or $text == 'درس'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📚=================درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🖕================درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📙===============درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🖕🏻==============درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📘=============درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🖕🏼============درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📗===========درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🖕🏽==========درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📕=========درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🖕🏾========درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📒=======درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🖕🏿======درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📔=====درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⛈====درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📓===درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '☀️==درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '📖=درس']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '💦ای وای ']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '#درس_خر_است
بوص بوص بای😁💋']);

}
if($text == 'رقص مربع دو' or $text == 'دنس دو'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
🔽🔽🔽🔽🔽🔽🔽
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔼🔼🔼🔼🔼🔼🔼
🔼🔼🔼🔼🔼🔼🔼']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔼🔼🔼🔼🔼🔼🔼']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
🔽🔽🔽🔽🔽🔽🔽
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🔽🔽🔽🔽🔽🔽🔽
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️↖️
⤴️⤴️⤴️⤴️⤴️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️↖️
⤴️⤴️⤴️⤴️⤴️↖️↖️
⤴️⤴️⤴️⤴️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️↖️
⤴️⤴️⤴️⤴️⤴️↖️↖️
⤴️⤴️⤴️⤴️↖️↖️↖️
⤴️⤴️⤴️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️↖️
⤴️⤴️⤴️⤴️⤴️↖️↖️
⤴️⤴️⤴️⤴️↖️↖️↖️
⤴️⤴️⤴️↖️↖️↖️↖️
⤴️⤴️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️⤴️
⤴️⤴️⤴️⤴️⤴️⤴️↖️
⤴️⤴️⤴️⤴️⤴️↖️↖️
⤴️⤴️⤴️⤴️↖️↖️↖️
⤴️⤴️⤴️↖️↖️↖️↖️
⤴️⤴️↖️↖️↖️↖️↖️
⤴️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️⤴️↖️
⤴️⤴️⤴️⤴️⤴️↖️↖️
⤴️⤴️⤴️⤴️↖️↖️↖️
⤴️⤴️⤴️↖️↖️↖️↖️
⤴️⤴️↖️↖️↖️↖️↖️
⤴️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️⤴️↖️↖️
⤴️⤴️⤴️⤴️↖️↖️↖️
⤴️⤴️⤴️↖️↖️↖️↖️
⤴️⤴️↖️↖️↖️↖️↖️
⤴️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️⤴️↖️↖️↖️
⤴️⤴️⤴️↖️↖️↖️↖️
⤴️⤴️↖️↖️↖️↖️↖️
⤴️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️⤴️⤴️↖️↖️↖️↖️
⤴️⤴️↖️↖️↖️↖️↖️
⤴️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⤴️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
↖️↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅❎↖️↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅❎❎↖️↖️↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅❎❎❎❎↖️↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅❎❎❎❎❎↖️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️↖️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️↖️✳️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️↖️✳️✳️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️↖️✳️✳️✳️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅↖️✳️✳️✳️✳️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️↖️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️↖️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅↖️↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅↖️↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️▫️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️▫️⬜️❇️
✅🟦↖️↖️◾️⬜️❇️
✅🟦↖️↖️↖️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️▫️⬜️❇️
✅🟦↖️↖️◾️⬜️❇️
✅🟦↖️↖️◾️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️▫️⬜️❇️
✅🟦↖️↖️◾️⬜️❇️
✅🟦↖️🔹◾️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️▫️⬜️❇️
✅🟦♦️↖️◾️⬜️❇️
✅🟦🔹🔹◾️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦▫️▫️▫️⬜️❇️
✅🟦♦️❤️◾️⬜️❇️
✅🟦🔹🔹◾️⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅⬛️⬛️⬛️⬛️⬛️❇️
✅🟦🧡🧡🧡⬜️❇️
✅🟦❣️❤️❣️⬜️❇️
✅🟦💛💛💛⬜️❇️
✅🟥🟥🟥🟥⬜️❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '✅✳️✳️✳️✳️✳️❇️
✅❤️❤️❤️❤️❤️❇️
✅💜🧡🧡🧡💜❇️
✅💜❣️❤️❣️💜❇️
✅💜💛💛💛💜❇️
✅💙💙💙💙💙❇️
✅❎❎❎❎❎❎']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
✅❤️❤️❤️❤️❤️❇️
✅💜🧡🧡🧡💜❇️
✅💜❣️❤️❣️💜❇️
✅💜💛💛💛💜❇️
✅💙💙💙💙💙❇️
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
✅❤️❤️❤️❤️❤️🤍
✅💜🧡🧡🧡💜🤍
✅💜❣️❤️❣️💜🤍
✅💜💛💛💛💜🤍
✅💙💙💙💙💙🤍
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
🖤❤️❤️❤️❤️❤️🤍
🖤💜🧡🧡🧡💜🤍
🖤💜❣️❤️❣️💜🤍
🖤💜💛💛💛💜🤍
🖤💙💙💙💙💙🤍
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
🖤❤️❤️❤️❤️❤️🤍
🖤💜❤️❤️❤️💜🤍
🖤💜❣️❤️❣️💜🤍
🖤💜❤️❤️❤️💜🤍
🖤💙💙💙💙💙🤍
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
🖤❤️❤️❤️❤️❤️🤍
🖤❤️❤️❤️❤️❤️🤍
🖤❤️❣️❤️❣️❤️🤍
🖤❤️❤️❤️❤️❤️🤍
🖤❤️❤️❤️❤️❤️🤍
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❣️❤️❣️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️🔴💛🔴❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️🔴💚🔴❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️🔴💙🔴❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '❣️❣️❣️❣️❣️❣️❣️
❤️❤️❤️❤️❤️❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️🔴💜🔴❤️❤️
❤️❤️❤️🔴❤️❤️❤️
❤️❤️❤️❤️❤️❤️❤️
❣️❣️❣️❣️❣️❣️❣️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '▫️◽️◻️⬜️◻️◽️▫️
❤️❤️❤️❤️❤️❤️⏪
❤️❤️❤️🔴❤️❤️⏪
❤️❤️🔴😍🔴❤️⏪
❤️❤️❤️🔴❤️❤️⏪
❤️❤️❤️❤️❤️❤️⏪
▪️◾️◼️⬛️◼️◾️▪️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '▫️◽️◻️⬜️◻️◽️▫️
⏩❤️❤️❤️❤️❤️⏪
⏩❤️❤️🔴❤️❤️⏪
⏩❤️🔴💋🔴❤️⏪
⏩❤️❤️🔴❤️❤️⏪
⏩❤️❤️❤️❤️❤️⏪
▪️◾️◼️⬛️◼️◾️▪️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => 'پایان']);

}
if($text == 'دونبال عشق' or $text == 'عشقم دارم میام'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀________________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀_______________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀______________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀_____________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀____________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀___________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀__________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀_________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀________🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀_______🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀______🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀____🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀___🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀__🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🚶‍♀_🏃‍♂']);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '💙love💙']);
}
if($text == 'امام' or $text == 'مرگ بر امریکا'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '
⣿⣿⣿⣿⣿⡿⠋⠁⠄⠄⠄⠈⠘⠩⢿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⠃⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠻⣿⣿⣿⣿
⣿⣿⣿⣿⠄⠄⣀⣤⣤⣤⣄⡀⠄⠄⠄⠄⠙⣿⣿⣿
⣿⣿⣿⣿⡀⢰⣿⣿⣿⣿⣿⢿⠄⠄⠄⠄⠄⠹⢿⣿
⣿⣿⣿⣿⣿⡞⠻⠿⠟⠋⠉⠁⣤⡀⠄⠄⠄⠄⠄⠄
⣿⣿⣿⣿⣿⣿⣶⢼⣷⡤⣦⣿⠛⡰⢃⠄⠐⠄⠄⢸
⣿⣿⣿⣿⣿⣿⣿⡯⢍⠿⢾⡿⣸⣿⠰⠄⢀⠄⠄⡬
⣿⣿⣿⣿⣿⣿⣿⣴⣴⣅⣾⣿⣿⡧⠦⡶⠃⠄⠠⢴
⣿⣿⣿⣿⠿⠍⣿⣿⣿⣿⣿⣿⣿⢇⠟⠁⠄⠄⠄⠄
⠟⠛⠉⠄⠄⠄⡽⣿⣿⣿⣿⣿⣯⠏⠄⠄⠄⠄⠄⠄
⠄⠄⠄⢀⣾⣾⣿⣤⣯⣿⣿⡿⠃⠄⠄⠄⠄⠄⠄⠄ ']);
}
if($text == 'بشمارش'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "1⃣1⃣
1⃣1⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "2⃣2⃣
2⃣2⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "3⃣3⃣
3⃣3⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "4⃣4⃣
4⃣4⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "5⃣5⃣
5⃣5⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "6⃣6⃣
6⃣6⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "7⃣7⃣
7⃣7⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "8⃣8⃣
8⃣8⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "9⃣9⃣
9⃣9⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🔟🔟
🔟🔟"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "1⃣1⃣
1⃣1⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "1⃣2⃣
1⃣2⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "1⃣3⃣
1⃣3⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "1⃣4⃣
1⃣4⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "1⃣5⃣
1⃣5⃣"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "☘|‌سایدیم|☘"]);
}
if($text == 'سل' or $text == 'SL'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
S
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
Sl
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
Sla
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
Slam
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.       Slam
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.       🤍🖤🤍🖤
       slam
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🤍🖤🤍🖤
      🤍 slam🖤
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🤍🖤🤍🖤
       🖤slam🤍 
        🤍🖤🤍🖤
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💛💛💛💛
      💛 slam💛
      💛💛💛💛
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💚💚💚💚
      💚 slam💚
      💚💚💚💚
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💖💖💖💖
      💖 slam💖
      💖💖💖💖
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💜💜💜💜
      💜 slam💜
      💜💜💜💜
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      ❤️❤️❤️❤️
      ❤️ slam❤️
      ❤️❤️❤️❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      ❤️❤️❤️❤️
      ❤️ slam❤️
      ❤️❤️❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      ❤️❤️❤️❤️
      ❤️ slam❤️
      ❤️❤️
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      ❤️❤️❤️❤️
      ❤️ slam❤️
      💛💜💛💜
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      ❤️❤️❤️❤️
      💜 slam💛
      💛💜💛💜
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💛💜💛💜
      💜 slam💛
      💛💜💛💜
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
سلام
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
سلام به روی
"]);
sleep(0.5);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
سلام به روی ماهت
"]);
}
if($text == 'جنایتکارو بکش' or $text == 'بکششش'  or $text == 'خایمالو بکش'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂                 • 🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂                •  🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂               •   🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂              •    🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂             •     🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂            •      🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂           •       🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂          •        🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂         •         🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂        •          🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂       •           🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂      •            🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂     •             🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂    •              🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂   •               🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂  •                🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂 •                 🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "😂•                  🔫🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🤯                  🔫 🤠"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "فرد جنایتکار کشته شد :)"]);
}
if($text == 'س' or $text == '/salam'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
S
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
Sl
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
Sla
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
Slam
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.       Slam
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌼🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌼🌷💐
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌼💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷🌼
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌼
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷🌼
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌼💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷🌺
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌼🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌼slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌼🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌼🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌼💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💐🌹🌷🌼
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌼
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷🌼
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌼💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌼🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌼slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌼🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌼🌷💐
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌼💐
       🌸slam 🌸
        🌺🌹🌼💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷🌼
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌼
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷🌼
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌼💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌼🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      💐🌹🌷💐
       🌼slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌼🌹🌷💐
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌼🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌼💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷🌼
       🌸slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌼
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷🌼
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌹🌼💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌺🌼🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌸slam 🌸
        🌼🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌺🌹🌷💐
       🌼slam 🌸
        🌺🌹🌷💐
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
.      🌼🌹🌷💐
       🌸slam 🌸
        🌺🌹🌷💐
"]);
}
if($text == '/dns' or $text == 'دنس'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥??🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟪🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟪🟪🟪🟧🟧🟧
🟧🟧🟧🟪🟧🟪🟧🟧🟧
🟧🟧🟧🟪🟪🟪🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟪🟪🟪🟪🟪🟧🟧
🟧🟧🟪🟧🟧🟧🟪🟧🟧
🟧🟧🟪🟧🟦🟧🟪🟧🟧
🟧🟧🟪🟧🟧🟧🟪🟧🟧
🟧🟧🟪🟪🟪🟪🟪🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟪🟪🟪🟪🟪🟪🟪🟧
🟧🟪🟧🟧🟧🟧🟧🟪🟧
🟧🟪🟧🟦🟦🟦🟧🟪🟧
🟧🟪🟧🟦🟧🟦🟧🟪🟧
🟧🟪🟧🟦🟦🟦🟧🟪🟧
🟧🟪🟧🟧🟧🟧🟧🟪🟧
🟧🟪🟪🟪🟪🟪🟪🟪🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟪🟪🟪🟪🟪🟪🟪🟪🟪
🟪🟧🟧🟧🟧🟧🟧🟧🟪
🟪🟧🟦🟦🟦🟦🟦🟧🟪
🟪🟧🟦🟧🟧🟧🟦🟧🟪
🟪🟧🟦🟧⬜️🟧🟦🟧🟪
🟪🟧🟦🟧🟧🟧🟦🟧🟪
🟪🟧🟦🟦🟦🟦🟦🟧🟪
🟪🟧🟧🟧🟧🟧🟧🟧🟪
🟪🟪🟪🟪🟪🟪🟪🟪🟪']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟦🟦🟦🟦🟦🟦🟦🟧
🟧🟦🟧🟧🟧🟧🟧🟦🟧
🟧🟦🟧⬜️⬜️⬜️🟧🟦🟧
🟧🟦🟧⬜️⬜️⬜️🟧🟦🟧
🟧🟦🟧⬜️⬜️⬜️🟧🟦🟧
🟧🟦🟧🟧🟧🟧🟧🟦🟧
🟧🟦🟦🟦🟦🟦🟦🟦🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟦🟦🟦🟦🟦🟦🟦🟦🟦
🟦🟧🟧🟧🟧🟧🟧🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧🟧🟧🟧🟧🟧🟧🟦
🟦🟦🟦🟦🟦🟦🟦🟦🟦']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜️🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜️🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥⬜️⬜️🟥🟥🟥🟥
🟥🟥🟥🟥⬜⬜️🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥💙💙🟥🟥🟥🟥
🟥🟥🟥🟥💙💙🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟦🟦🟥🟥🟥🟥
🟥🟥🟥🟥🟦🟦🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟨🟨🟨🟨🟨🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟨🟨🟨🟨🟨🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟨🟪🟨🟨🟨🟨🟪🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟪🟨🟨🟨🟨🟪🟨🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧🟨🟦🟦🟨🟧🟪🟥
🟥🟪🟧🟦🟨🟨🟦🟧🟪🟥
🟥🟪🟧🟦🟨🟨🟦🟧🟪🟥
🟥🟪🟧🟨🟦🟦🟨🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥??🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧💛🟦🟦💛🟧🟪🟥
🟥🟪🟧🟦💛💛🟦🟧🟪🟥
🟥🟪🟧🟦💛💛🟦🟧🟪🟥
🟥🟪🟧💛🟦🟦💛🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪🖤🖤🖤🖤🟪🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟪🖤🖤🖤🖤🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥💜🟩🟩🟩🟩🟩🟩💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🟧💛💙💙💛🟧💜🟥
🟥💜🟧💙💛💛💙🟧💜🟥
🟥💜🟧💙💛💛💙🟧💜🟥
🟥💜🟧💛💙💙💛🟧💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🟩🟩🟩🟩🟩🟩💜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥💜💜🟩🟩🟩🟩🟩💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜🧡💙💙💛💙🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🟩🟩🟩🟩🟩🟩💜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥💜💚💚💚💚💚💚💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜💚💚💚💚💚💚💜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️◻️◽️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️⬜️⬜️◻️◽️▫️
⬜️⬜️⬜️⬜️⬜️⬜️◻️◽️◽️
⬜️⬜️⬜️⬜️⬜️⬜️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️⬜️◻️◽️▫️▫️
⬜️⬜️⬜️⬜️⬜️◻️◽️▫️▫️
⬜️⬜️⬜️⬜️⬜️◻️◽️◽️◽️
⬜️⬜️⬜️⬜️⬜️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️⬜️◻️◽️▫️▫️▫️
⬜️⬜️⬜️⬜️◻️◽️▫️▫️▫️
⬜️⬜️⬜️⬜️◻️◽️▫️▫️▫️
⬜️⬜️⬜️⬜️◻️◽️◽️◽️◽️
⬜️⬜️⬜️⬜️◻️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️◽️◽️◽️◽️
⬜️⬜️⬜️◻️◻️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️◽️◽️◽️◽️◽️
⬜️⬜️◻️◻️◻️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️◽️◽️◽️◽️◽️◽️
⬜️◻️◻️◻️◻️◻️◻️◻️◽️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️◽️◽️◽️◽️◽️◽️◽️
◻️◻️◻️◻️◻️◻️◻️◻️◻️']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️◽️◽️◽️◽️◽️◽️◽️◽']);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️']);
}
if($text == 'رقص ایموجی' or $text == 'emojidanc'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~( ._.)--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--(._. )~-
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~( ._.)--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--(._. )~-
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~
"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~( ._.)--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--(._. )~-
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~

"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
-~(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
~-(._. )--

"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)~-
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
--( ._.)-~
تامام
"]);
}
if($text == 'کیکک' or $text == 'kirr'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "


.                                🟦🟦🟦🟦🟦
                                


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟦🟦🟦
                                 🟦
                                 🟦
                                 🟦
                                 🟦
 


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟦🟦🟦
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
         🟦🟦🟦🟦🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟦🟦🟦
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦
🟦       


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "


.                                🟦🟦🟦🟦🟦
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟦🟦🟦
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟦🟦🟥
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟦🟥🟥
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟦🟥🟥🟥
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟦🟥🟥🟥🟥
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟦
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟦
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟦
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟦     🟦
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟦     🟥
          🟦🟦🟦🟦🟦🟦
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟦     🟥
          🟦🟦🟦🟦🟦🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟦     🟥
          🟦🟦🟦🟦🟥🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟦     🟥
          🟦🟦🟦🟥🟥🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟦🟦🟦🟥🟥🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟦🟦🟥🟥🟥🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟦🟥🟥🟥🟥🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟦🟦
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟦🟥
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟥🟥
🟦🟦        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟥🟥
🟦🟥        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟥🟥
🟥🟥        🟦🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟥🟥
🟥🟥        🟥🟦


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟥🟥🟥🟥🟥
                                 🟥
                                 🟥
                                 🟥
                       🟥     🟥
          🟥🟥🟥🟥🟥🟥
     🟥🟥
🟥🟥        🟥🟥


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟥🟥
🟥🟥        🟥🟥


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦⬛️
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩⬛️🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨⬛️🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧⬛️🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                ⬛️🟨🟩🟥🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 ⬛️
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 ⬛️
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟥
                                 🟩
                                 ⬛️
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     ⬛️
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨⬛️
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩⬛️🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪⬛️🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       ⬛️     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️⬛️🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟥
                                 🟩
                       🟦     🟨
          🟫⬛️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          ⬛️⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬛️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     ⬛️⬜️
🟩🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩⬛️        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟥
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
⬛️🟦        🟨🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟥     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        ⬛️🟧


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                🟧🟨🟩🟦🟪
                                 🟪
                                 🟦
                                 🟩
                       🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨⬛️


"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "

.                                  🟧🟨🟩🟦🟪
                                   🟪
                                   🟦
                                   🟩
                         🟦     🟨
          🟫⬜️🟪🟩🟨🟧
     🟪⬜️
🟩🟦        🟨🟧

بیب بیب
"]);
}
if($text == 'بکشش' or $text == '/bokoshesh'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐                     •🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐                    • 🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐                  •   🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐                •     🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐              •       🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐            •         🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐           •          🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐         •            🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐       •              🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐     •                🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐   •                  🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐 •                    🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😐•                     🔫
"]);

yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "
😵                       🔫😏
"]);
}
if($text == 'هالوین' or $text == 'کدو' or $text == 'چاقووو' or $text == 'halloween'){
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪               🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪              🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪             🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪            🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪           🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪          🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪         🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪        🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪       🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪      🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪     🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪    🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪   🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪  🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪 🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🔪🎃']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' => '🎃']);
}
if($text == 'موتور' or $text == 'motor' or $text == 'شوتور'){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => '🚧___________________🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_________________🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_______________🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_____________🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧___________🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_________🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_______🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_____🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧____🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧__🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧_🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '🚧🛵']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => 'وای تصادف شد']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => 'وای موتورم بـگا رف']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => 'ریدم تو موتورم']);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id + 1, 'message' => '💥BOOM💥']);
}

if($text == 'پنالتی' or $text == 'فوتبال'){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️





                     😐          ⚽️
                     👕 
                     👖
////////////////////
"]);
yield $this->sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️




                     😐
                     👕       ⚽️
                     👖
////////////////////
"]);
yield $this->sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️




                           😐
                           👕 ⚽️
                           👖
////////////////////
"]);
yield $this->sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️



                                             ⚽️
                           😐
                           👕 
                           👖
////////////////////
"]);
yield $this->sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️

                                                       ⚽️

                                             
                           😐
                           👕 
                           👖
////////////////////
"]);
yield $this->sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⚽️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️

                                                      

                                             
                           😐
                           👕 
                           👖
////////////////////
"]);
yield $this->sleep(1);
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⚽️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️

                                                      

                                 💭Gooooooooolllllllll       
                           😐
                           👕 
                           👖
////////////////////
"]);
}
if($text == 'جن' or $text == 'روح'  or $text == 'روحح'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                                   🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                                  🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                                 🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                                🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                               🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                              🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                             🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                            🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                           🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                          🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                         🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                        🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                       🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                      🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                     🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                    🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                   🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                  🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻                 🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻               🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻              🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻             🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻            🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻           🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻          🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻         🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻        🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻       🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻      🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻     🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻    🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻   🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻  🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻 🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "👻🙀"]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "☠بگارف☠"]);
}
if($text == 'چنگیز' or $text == 'changiz'){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => '   
   *／ イ  *   　　　((( ヽ*♤
​(　 ﾉ　　　　 ￣Ｙ＼​
​| (＼　(\🎩/)   ｜    )​♤
​ヽ　ヽ` ( ͡° ͜ʖ ͡°) _ノ    /​ ♤
　​＼ |　⌒Ｙ⌒　/  /​♤
　​｜ヽ　 ｜　 ﾉ ／​♤
　 ​＼トー仝ーイ​♤
　　 ​｜ ミ土彡 |​♤
         ​) \      °     /​♤
         ​(     \       /​l♤
         ​/       / ѼΞΞΞΞΞΞΞD​💦
      ​/  /     /      \ \   \​ 
      ​( (    ).           ) ).  )​♤
     ​(      ).            ( |    |​ 
      ​|    /                \    |​♤
         ☆͍ 。͍✬͍​͍。͍☆͍​͍​͍
 ͍​͍ ​͍​͍☆͍。͍＼͍｜͍／͍。͍ ☆͍ ​͍✬͍​͍ ☆͍​͍​͍​͍
​͍ ͍​͍  *͍~max self~*
 ͍ ​͍​͍​͍☆͍。͍／͍｜͍＼͍。͍ ☆͍ ​͍✬͍​͍☆͍​͍​͍​͍
​͍​͍​͍。͍☆͍ 。͍✬͍​͍。͍☆͍​͍​͍​͍']);
}
if($text == 'tas' or $text == 'تاس'){
$tas="
-+-+-+-+-+-+
  | 012  |
  | 345  |
  | 678  |
-+-+-+-+-+-+";
$rand002=rand(1,6);
if($rand002==1){
$tas=str_replace(4,"🤍",$tas);
}
if($rand002==2){
$tas=str_replace([0,8],"❤️",$tas);
}
if($rand002==3){
$tas=str_replace([0,4,8],"💚",$tas);
}
if($rand002==4){
$tas=str_replace([0,2,6,8],"💙",$tas);
}
if($rand002==5){
$tas=str_replace([0,2,6,8,4],"❤",$tas);
}
if($rand002==6){
$tas=str_replace([0,2,6,8,3,5],"🖕",$tas);
}

$tas=str_replace(range(0,8),'   ',$tas);

$ed = $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' =>$tas, 'parse_mode' => 'HTML' ]);
}
if($text == 'bas' or $text == 'بسکت'){
$bas="
===🔲 1
| 3
| 2
| 0 ";
$rand003=rand(1,4);
if($rand003==1){
$bas=str_replace(0,"🏀",$bas);
}
if($rand003==2){
$bas=str_replace([3,],"🏀",$bas);
}
if($rand003==3){
$bas=str_replace([1,],"🏀",$bas);
}
if($rand003==4){
$tas=str_replace([2,],"🏀",$bas);
}
$bas=str_replace(range(0,3),'   ',$bas);
$ed = $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id, 'message' =>$bas, 'parse_mode' => 'HTML' ]);
} 
  
if($text == 'time' or $text == 'ساعت'  or $text == 'تایم'){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => ';)']);
	for ($i=1;$i <= 600;$i++){
yield $this->messages->editMessage(['peer' =>$peer, 'id' =>$msg_id +1, 'message' => date('H:i:s')]);
yield $this->sleep(1);
}
}
if($text == 'ping' or $text == '/ping' or $text == 'پینگ'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "روشنم 😒"]);
}
if(preg_match("/^[\/\#\!]?(setanswer) (.*)$/i",$text)){
$ip = trim(str_replace("/setanswer ","",$text));
$ip = explode("|",$ip."|||||");
$txxt = trim($ip[0]);
$answeer = trim($ip[1]);
if(!isset($data['answering'][$txxt])){
$data['answering'][$txxt] = $answeer;
file_put_contents("data.json", json_encode($data));
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "کلمه جدید به لیست پاسخ شما اضافه شد👌🏻"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "این کلمه از قبل موجود است :/"]);
}
}

if(preg_match("/^[\/#!]?(بگو) (.*)$/i",$text,$m)){
$taks = str_split($m[2]);
$send = false;
for ($i = 0;$i < sizeof($taks);$i++){
if(in_array($taks[$i].$taks[$i+1], str_split('ضصثقفغعهخ؟آحجچپگکمنتالبیسشظطزرذدئو',2)))
$send .= $taks[$i] .$taks[++$i];
else
$send .= $taks[$i];
if($taks[$i] !== " ")
yield $this->messages->editMessage([
'peer' =>$peer,
'id' =>$msg_id,
'message' =>$send
]);
}
}
if(preg_match("/^[\/\#\!]?(delanswer) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(delanswer) (.*)$/i",$text,$text);
$txxt = $text[2];
if(isset($data['answering'][$txxt])){
unset($data['answering'][$txxt]);
file_put_contents("data.json", json_encode($data));
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "کلمه مورد نظر از لیست پاسخ حذف شد👌🏻"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "این کلمه در لیست پاسخ وجود ندارد :/"]);
}
}

if($text == '/die;'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => '!..!']);
yield $this->restart();
  die;
}
if($text == '/id' or $text == 'id'){
if($replyToId){
if($type3 == 'supergroup' or $type3 == 'chat'){
$gms = yield $this->channels->getMessages(['channel' => $peer, 'id' => [$replyToId]]);
$messag = $gms['messages'][0]['from_id']['user_id'];
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => 'YourID : '.$messag, 'parse_mode' => 'markdown']);
}else{
if($type3 == 'user'){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "YourID : `$peer`", 'parse_mode' => 'markdown']);
}
}
}else{
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "GroupID : `$peer`", 'parse_mode' => 'markdown']);
}
}
if($replyToId){
if($text == 'unblock' or $text == '/unblock' or $text == '!unblock'){
if($type3 == 'supergroup' or $type3 == 'chat'){
$gms = yield $this->channels->getMessages(['channel' => $peer, 'id' => [$replyToId]]);
$messag = $gms['messages'][0]['from_id']['user_id'];
yield $this->contacts->unblock(['id' =>$messag]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "UnBlocked!"]);
}else{
if($type3 == 'user'){
yield $this->contacts->unblock(['id' =>$peer]);yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "UnBlocked!"]);
}
}
}
if($text == 'block' or $text == '/block' or $text == '!block'){
if($type3 == 'supergroup' or $type3 == 'chat'){
$gms = yield $this->channels->getMessages(['channel' => $peer, 'id' => [$replyToId]]);
$messag = $gms['messages'][0]['from_id']['user_id'];
yield $this->contacts->block(['id' =>$messag]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Blocked!"]);
}else{
if($type3 == 'user'){
yield $this->contacts->block(['id' =>$peer]);yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Blocked!"]);
}
}
}
$partmode=file_get_contents("part.txt");
if(preg_match("/^[\/\#\!]?(part) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(part) (on|off)$/i",$text,$m);
file_put_contents('part.txt',$m[2]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "🇵 🇦 🇷 🇹  N̾o̾w̾  Is$m[2]"]);
}
if(preg_match("/^[\/\#\!]?(setenemy) (.*)$/i",$text)){
$gms = yield $this->channels->getMessages(['channel' => $peer, 'id' => [$replyToId]]);
$messag = $gms['messages'][0]['from_id']['user_id'];
if(!in_array($messag,$data['enemies'])){
 $data['enemies'][] = $messag;
file_put_contents("data.json", json_encode($data));
yield $this->contacts->block(['id' =>$messag]);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "$messag is now in enemy list"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "This User Was In EnemyList"]);
}
}
if(preg_match("/^[\/\#\!]?(delenemy) (.*)$/i",$text)){
$gms = yield $this->channels->getMessages(['channel' => $peer, 'id' => [$replyToId]]);
$messag = $gms['messages'][0]['from_id']['user_id'];
if(in_array($messag,$data['enemies'])){
 $k = array_search($messag,$data['enemies']);
    unset($data['enemies'][$k]);
file_put_contents("data.json", json_encode($data));
yield $this->contacts->unblock(['id' =>$messag]);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "$messag deleted from enemy list"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "This User Wasn't In EnemyList"]);
}
}
}
if(preg_match("/^[\/\#\!]?(answerlist)$/i",$text)){
if(count($data['answering']) > 0){
$txxxt = "لیست پاسخ ها :
";
$counter = 1;
foreach($data['answering'] as$k =>$ans){
$txxxt .= "$counter: $k =>$ans \n";
$counter++;
}
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$txxxt]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "پاسخی وجود ندارد!"]);
}
}
if($text == 'help' or $text == 'راهنما'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "راهنمای سلف:مکس
نسخه : 2.0
(k)(کاربردی)
برای بدست آوردن راهنما کاربردی🤲 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
(S) (سرگرمی)
برای بدست آوردن راهنمای سرگرمی🤑
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
(m)(مدیریت) 
برای بدست آوردن راهنمای مدیریت 😁
♧°•°•°•°•°•°•°•°•°•°•°•°•°•♧
(b)(دعوا) 
برای بدست آوردن بخش بگادهنده🥺
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
(ss)(سریع) 
برای بدست آوردن بخش پاسخ سریع👨‍💻 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
`confing` | `پیکربندی`
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
•••[ @TKPHP ]•••
♻️ مقدار رم درحال استفاده : $mem_using مگابایت
",
'parse_mode' => 'markdown']);
}
if($text == 'K' or $text == 'کاربردی'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "
سلام به بخش کاربردی خودتون خوش آمدید❤️ 
 
/bot (on) øř (off) 
دستور ربات برای خاموش یا روشن 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
spam2 (تعداد عدد)  (متن) 
اسپم صورت پیام های تکراری 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
setusername (اسم مدنظر) 
تنظیم نام کاربری 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
profile [نام] | [خانوادگی] | [بیو] 
تنظیم نام اسم , فامیل و بیوگرافی ربات 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/sticker (متن) 
متن تبدیل به استیکر 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/gif(متن یا پوکر) 
متن یا پوکر تبدیل به گیف 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/upload (url) 
آپلود فایل از لینک 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/weather (شهر) 
آب و هوای منطقه مدنظرتون 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/music (متن یا اسم) 
موزیک مدنظرتون 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/info (یوزرنیم یا آیدی عددی) 
اطلاعات کاربر 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/id  (ریپلای) 
دریافت آیدی عددی ریپلای شده 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/gpinfo 
اطلاعات گروه مدنظر شما باید داخل گروه گفته بشود! 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/sessions 
دریافت اطلاعات نشست های خود 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/save (ریپلای) 
رو پیامی که میخواهید ذخیره شود در پیام های ذخیره ریپلای میکنیم 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
left لفت 
از گروه مدنظرتون خروج میکند 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
gogle (سرچ) 
گوگل 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
joke 
دریافت جوک های خنده دار 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/like (متن) 
متن مدنظر شما بصورت لایکدار میشود 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
adduser (userid) (idgp) 
ادد کردن یک کاربر به یک گروه مدنظرتون 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
contacts (on) øř (off) 
فعال شدن حالت اددشدن مخاطبین به صورت خودکار 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/info (@username)
دریافت اطلاعات کاربر
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
بگو [text]
ادیت تیکه تیکه متن 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
•••[ @TKPHP ]•••
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
♻️ مقدار رم درحال استفاده : $mem_using مگابایت
",
'parse_mode' => 'markdown']);
}
if($text == 'مدیریت' or $text == 'm'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield
$this->messages->sendMessage(['peer' =>$peer, 'message' => " typing (on) øř (off) 
تایپ روشن یا خاموش 
درحالی که هرگروه بعداز پیام بالا گروه نوار مواجه با درحال تایپ کردن شما میشونند 
 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
onlin (on)øř(off)
خاموش روشن کردن همیشه انلاین 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
Tag [on|off] 
 #روشن/#خاموش کردن حالت تگ نوشتن 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
markread (on) øř (off) 
حالت خوانده شدن پیام ها روشن یا خاموش 
 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
timename (on) øř (off) 
این دستور برای تایم رو اسم  میباشد 
حتما سلفتونو کرونجاب کنیید🤤💋 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
/restart
صفر کردن رم
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
(status) or (مصرف)
اطلاع بودن از مصرف رم 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
•••[ @TKPHP ]•••
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
♻️ مقدار رم درحال استفاده : $mem_using مگابایت
",
'parse_mode' => 'markdown']);
}
if($text == 'سریع' or $text == 'ss'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield
$this->messages->sendMessage(['peer' =>$peer, 'message' => "  سلام به بخش جواب سریع خودتون خوش آمدید❤️ 
 
/setanswer (text) | (answer) 
افزودن جواب سریع (متن اول متن دریافتی از کاربر و ددوم جوابی که ربات بدهد) 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/delanswer (متن) 
حذف جواب سریع 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
/clean answers 
حذف لیست جواب های سریع 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧  
/answerlist 
دریافت لیست تمام جواب های سریع 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
•••[ @TKPHP ]•••
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
♻️ مقدار رم درحال استفاده : $mem_using مگابایت
",
'parse_mode' => 'markdown']);
}
if($text == 'سرگرمی ها' or $text == 'سرگرمی'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield
$this->messages->sendMessage(['peer' =>$peer, 'message' => "
رََََِِاََََِِهََََِِنََََِِمََََِِاََََِِ ََََِِسََََِِلََََِِفََََِِ سََََِِرََََِِگََََِِرََََِِمََََِِیََََِِ 


⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿
بکشش🤕
------------------------------------
س✊
------------------------------------
سلام👻
------------------------------------
قلب❤️
------------------------------------
تاس🎲
------------------------------------
چنگیز⛱
------------------------------------
جن👺
------------------------------------
فوتبال⚽️
------------------------------------
موتور🏍
------------------------------------
کدو 🥢
------------------------------------
کیکک🖕🏻
------------------------------------
رقص‌ ایموجی 😻
------------------------------------
دنس🤐
------------------------------------
سل👣
------------------------------------
امام👨‍🦯
------------------------------------
دونبال عشق 🧍
------------------------------------
دنس دو🙇‍♂
------------------------------------
درس 🪂
------------------------------------
موک👷‍♂
------------------------------------
تله😼
------------------------------------
خونشام🧟‍♂
------------------------------------
کییر🧞‍♀
------------------------------------
لبخند😁
------------------------------------
ناراحت😕
------------------------------------
عاشق 🚶‍♂
------------------------------------
اوپس💋
------------------------------------
صیک کن 😒
------------------------------------
کیرم 🖕🏿
------------------------------------
صیک🤗
------------------------------------
بوص😍
------------------------------------
حلقه😎
------------------------------------
زندگی 😒
------------------------------------
قلبز🖤
------------------------------------
مرغ 🐥
------------------------------------
رقصصص🦕
------------------------------------
ریدم 😂
------------------------------------
بخند 😐😂
------------------------------------
سردار💜
------------------------------------
دلار 🎭
------------------------------------
نامه 🤹‍♂
------------------------------------
لامپ 🚀
------------------------------------
نویسنده | سازنده 🥀
------------------------------------
گوه خور 💩
------------------------------------
رقص ایموجی 😄
------------------------------------
شکست عشقی 😔
------------------------------------
ریدیم 🤣
------------------------------------
سل 🙃
------------------------------------

⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿
•••[ @TKPHP ]•••
⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿⦿
♻️ قدار رم درحال استفاده : $mem_using مگابایت
",
'parse_mode' => 'markdown']);
}
if($text == 'دعوا' or $text == 'b'){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
yield
$this->messages->sendMessage(['peer' =>$peer, 'message' => " سلام به بخش بگادهنده 😈خودتون خوش آمدید❤️ 
 
!setenemy (آیدی عددی) ya (ریپلای) 
تنظیم دشمن با استفاده از آیدی عددی یا ریپلای 
🍆🍌🍑 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
!delenemy (آیدی عددی) ya (ریپلای) 
• حذف دشمن با استفاده از آیدی عددی یا ریپلای 
👍🚶‍♂️ 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
!clean enemylist 
• پاک کردن لیست دشمنان 
💫☹️ 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
block (آیدی) ya (ریپلای) 
• بلاک کردن شخصی خاص در ربات 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧ 
unblock (آیدی) ya (ریپلای) 
• آزاد کردن شخصی خاص از بلاک در ربات 
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧
•••[ @TKPHP ]•••
♧°•°•°•°•°•°•°•°•°•°•°•°•°•°♧  
♻️ مقدار رم درحال استفاده : $mem_using مگابایت
",
'parse_mode' => 'markdown']);
}
if($message and $data['tag'] == "on"){
$a = $text;
@$a = str_replace(" ",'',$a);
@$a = str_replace("\n",'\n#',$a);
$op = "#".$a;
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' =>$op]);
}
if($message and $data['tag'] == "on"){
$a = $text;
@$a = str_replace(" ",'‌',$a);
@$a = str_replace("\n",'\n#',$a);
$op = "#".$a;
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' =>$op]);
}
if(preg_match("/^[\/\#\!]?(tag) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(tag) (on|off)$/i",$text,$m);
$data['tag'] = $m[2];
file_put_contents("data.json", json_encode($data));
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Tag Mode Now Is$m[2]"]);
}
if(preg_match("/^[\/\#\!]?(save)$/i",$text) and $replyToId){
$me = yield $this->getSelf();
$me_id = $me['id'];
yield $this->messages->forwardMessages(['from_peer' =>$peer, 'to_peer' =>$me_id, 'id' => [$message['reply_to_msg_id']]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "> Saved :D"]);
}
if(preg_match("/^[\/\#\!]?(typing) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(typing) (on|off)$/i",$text,$m);
$data['typing'] = $m[2];
file_put_contents("data.json", json_encode($data));
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Typing Now Is$m[2]"]);
}
if(preg_match("/^[\/\#\!]?(echo) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(echo) (on|off)$/i",$text,$m);
$data['echo'] = $m[2];
file_put_contents("data.json", json_encode($data));
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Echo Now Is$m[2]"]);
}
if(preg_match("/^[\/\#\!]?(markread) (on|off)$/i",$text)){
preg_match("/^[\/\#\!]?(markread) (on|off)$/i",$text,$m);
$data['markread'] = $m[2];
file_put_contents("data.json", json_encode($data));
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Markread Now Is$m[2]"]);
}
$action = "sendMessageGamePlayAction";
 
$act = ['_' =>$action];
yield $this->messages->setTyping(['peer' =>$peer, 'action' =>$act]);
 
if(preg_match("/^[\/\#\!]?(info) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(info) (.*)$/i",$text,$m);
$mee = yield $this->getFullInfo($m[2]);
$me = $mee['User'];
$me_id = $me['id'];
$me_status = $me['status']['_'];
$me_bio = $mee['full']['about'];
$me_common = $mee['full']['common_chats_count'];
$me_name = $me['first_name'];
$me_uname = $me['username'];
$mes = "ID: $me_id \nName: $me_name \nUsername: @$me_uname \nStatus: $me_status \nBio: $me_bio \nCommon Groups Count: $me_common";
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' =>$mes]);
}
if(preg_match("/^[\/\#\!]?(block) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(block) (.*)$/i",$text,$m);
yield $this->contacts->block(['id' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Blocked!"]);
}
if(preg_match("/^[\/\#\!]?(unblock) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(unblock) (.*)$/i",$text,$m);
yield $this->contacts->unblock(['id' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "UnBlocked!"]);
}
if(preg_match("/^[\/\#\!]?(checkusername) (@.*)$/i",$text)){
preg_match("/^[\/\#\!]?(checkusername) (@.*)$/i",$text,$m);
$check = yield $this->account->checkUsername(['username' => str_replace("@", "",$m[2])]);
if($check == false){
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Exists!"]);
}else{
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Free!"]);
}
}
if(preg_match("/^[\/\#\!]?(setfirstname) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(setfirstname) (.*)$/i",$text,$m);
yield $this->account->updateProfile(['first_name' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Done!"]);
}
if(preg_match("/^[\/\#\!]?(setlastname) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(setlastname) (.*)$/i",$text,$m);
yield $this->account->updateProfile(['last_name' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Done!"]);
}
if(preg_match("/^[\/\#\!]?(setbio) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(setbio) (.*)$/i",$text,$m);
yield $this->account->updateProfile(['about' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Done!"]);
}
if(preg_match("/^[\/\#\!]?(setusername) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(setusername) (.*)$/i",$text,$m);
yield $this->account->updateUsername(['username' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Done!"]);
}
if(preg_match("/^[\/\#\!]?(j) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(j) (.*)$/i",$text,$m);
yield $this->channels->joinChannel(['channel' =>$m[2]]);
yield $this->messages->editMessage(['peer' =>$peer,'id' =>$msg_id,'message' => "Joined!"]);
}
if(preg_match("/^[\/\#\!]?(add2all) (@.*)$/i",$text)){
preg_match("/^[\/\#\!]?(add2all) (@.*)$/i",$text,$m);
$dialogs = yield $this->getDialogs();
foreach ($dialogs as$peeer){
$peer_info = yield $this->getInfo($peeer);
$peer_type = $peer_info['type'];
if($peer_type == "supergroup"){
yield $this->channels->inviteToChannel(['channel' =>$peeer, 'users' => [$m[2]]]);
}
}
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "Added To All SuperGroups"]);
}
if(preg_match("/^[\/\#\!]?(newanswer) (.*) \|\|\| (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(newanswer) (.*) \|\|\| (.*)$/i",$text,$m);
$txxt = $m[2];
$answeer = $m[3];
if(!isset($data['answering'][$txxt])){
$data['answering'][$txxt] = $answeer;
file_put_contents("data.json", json_encode($data));
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "New Word Added To AnswerList"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "This Word Was In AnswerList"]);
}
}
if(preg_match("/^[\/\#\!]?(delanswer) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(delanswer) (.*)$/i",$text,$m);
$txxt = $m[2];
if(isset($data['answering'][$txxt])){
unset($data['answering'][$txxt]);
file_put_contents("data.json", json_encode($data));
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "Word Deleted From AnswerList"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "This Word Wasn't In AnswerList"]);
}
}
if(preg_match("/^[\/\#\!]?(clean answers)$/i",$text)){
$data['answering'] = [];
file_put_contents("data.json", json_encode($data));
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "AnswerList Is Now Empty!"]);
}
if(preg_match("/^[\/\#\!]?(setenemy) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(setenemy) (.*)$/i",$text,$m);
$mee = yield $this->getFullInfo($m[2]);
$me = $mee['User'];
$me_id = $me['id'];
$me_name = $me['first_name'];
if(!in_array($me_id,$data['enemies'])){
$data['enemies'][] = $me_id;
file_put_contents("data.json", json_encode($data));
yield $this->contacts->block(['id' =>$m[2]]);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "$me_name is now in enemy list"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "This User Was In EnemyList"]);
}
}
if(preg_match("/^[\/\#\!]?(delenemy) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(delenemy) (.*)$/i",$text,$m);
$mee = yield $this->getFullInfo($m[2]);
$me = $mee['User'];
$me_id = $me['id'];
$me_name = $me['first_name'];
if(in_array($me_id,$data['enemies'])){
$k = array_search($me_id,$data['enemies']);
unset($data['enemies'][$k]);
file_put_contents("data.json", json_encode($data));
yield $this->contacts->unblock(['id' =>$m[2]]);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "$me_name deleted from enemy list"]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "This User Wasn't In EnemyList"]);
}
}
if(preg_match("/^[\/\#\!]?(clean enemylist)$/i",$text)){
$data['enemies'] = [];
file_put_contents("data.json", json_encode($data));
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "EnemyList Is Now Empty!"]);
}
if(preg_match("/^[\/\#\!]?(enemylist)$/i",$text)){
if(count($data['enemies']) > 0){
$txxxt = "EnemyList:
";
$counter = 1;
foreach($data['enemies'] as$ene){
$mee = yield $this->getFullInfo($ene);
$me = $mee['User'];
$me_name = $me['first_name'];
$txxxt .= "$counter: $me_name \n";
$counter++;
}
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$txxxt]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "No Enemy!"]);
}
}
if(preg_match("/^[\/\#\!]?(inv) (@.*)$/i",$text) and $update['_'] == "updateNewChannelMessage"){
preg_match("/^[\/\#\!]?(inv) (@.*)$/i",$text,$m);
$peer_info = yield $this->getInfo($message['to_id']);
$peer_type = $peer_info['type'];
if($peer_type == "supergroup"){
yield $this->channels->inviteToChannel(['channel' =>$message['to_id'], 'users' => [$m[2]]]);
}else{
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "Just SuperGroups"]);
}
}
if($text==  'لفت' or $text== 'left'){
yield $this->channels->leaveChannel(['channel' =>$peer]);
yield $this->channels->deleteChannel(['channel' =>$peer ]);
}
if(preg_match("/^[\/\#\!]?(flood) ([0-9]+) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(flood) ([0-9]+) (.*)$/i",$text,$m);
$count = $m[2];
$txt = $m[3];
$spm = "";
for($i=1;$i <= $count;$i++){
$spm .= "$txt \n";
}
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$spm]);
}
if(preg_match("/^[\/\#\!]?(flood2) ([0-9]+) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(flood2) ([0-9]+) (.*)$/i",$text,$m);
$count = $m[2];
$txt = $m[3];
for($i=1;$i <= $count;$i++){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$txt]);
}
}
if(preg_match("/^[\/\#\!]?(music) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(music) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@melobot", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][rand(0, count($messages_BotResults['results']))]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(wiki) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(wiki) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@wiki", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][rand(0, count($messages_BotResults['results']))]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(youtube) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(youtube) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@uVidBot", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][rand(0, count($messages_BotResults['results']))]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(pic) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(pic) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@pic", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][rand(0, count($messages_BotResults['results']))]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(gif) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(gif) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@gif", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][rand(0, count($messages_BotResults['results']))]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(google) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(google) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@GoogleDEBot", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][rand(0, count($messages_BotResults['results']))]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(joke)$/i",$text)){
preg_match("/^[\/\#\!]?(joke)$/i",$text,$m);
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@function_robot", 'peer' =>$peer, 'query' => '', 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][0]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(aasab)$/i",$text)){
preg_match("/^[\/\#\!]?(aasab)$/i",$text,$m);
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@function_robot", 'peer' =>$peer, 'query' => '', 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][1]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(like) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(like) (.*)$/i",$text,$m);
$mu = $m[2];
$messages_BotResults = yield $this->messages->getInlineBotResults(['bot' => "@like", 'peer' =>$peer, 'query' =>$mu, 'offset' => '0']);
$query_id = $messages_BotResults['query_id'];
$query_res_id = $messages_BotResults['results'][0]['id'];
yield $this->messages->sendInlineBotResult(['silent' => true, 'background' => false, 'clear_draft' => true, 'peer' =>$peer, 'reply_to_msg_id' =>$message['id'], 'query_id' =>$query_id, 'id' => "$query_res_id"]);
}
if(preg_match("/^[\/\#\!]?(search) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(search) (.*)$/i",$text,$m);
$q = $m[2];
$res_search = yield $this->messages->search(['peer' =>$peer, 'q' =>$q, 'filter' => ['_' => 'inputMessagesFilterEmpty'], 'min_date' => 0, 'max_date' => time(), 'offset_id' => 0, 'add_offset' => 0, 'limit' => 50, 'max_id' =>$message['id'], 'min_id' => 1]);
$texts_count = count($res_search['messages']);
$users_count = count($res_search['users']);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => "Msgs Found: $texts_count \nFrom Users Count: $users_count"]);
foreach($res_search['messages'] as$text){
$textid = $text['id'];
yield $this->messages->forwardMessages(['from_peer' =>$text, 'to_peer' =>$peer, 'id' => [$textid]]);
}
}
elseif(preg_match("/^[\/\#\!]?(weather) (.*)$/i",$text)){
preg_match("/^[\/\#\!]?(weather) (.*)$/i",$text,$m);
$query = $m[2];
$url = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$query."&appid=eedbc05ba060c787ab0614cad1f2e12b&units=metric"), true);
$city = $url["name"];
$deg = $url["main"]["temp"];
$type1 = $url["weather"][0]["main"];
if($type1 == "Clear"){
$tpp = 'آفتابی☀';
file_put_contents('type.txt',$tpp);
}
elseif($type1 == "Clouds"){
$tpp = 'ابری ☁☁';
file_put_contents('type.txt',$tpp);
}
elseif($type1 == "Rain"){
$tpp = 'بارانی ☔';
file_put_contents('type.txt',$tpp);
}
elseif($type1 == "Thunderstorm"){
$tpp = 'طوفانی ☔☔☔☔';
file_put_contents('type.txt',$tpp);
}
elseif($type1 == "Mist"){
$tpp = 'مه 💨';
file_put_contents('type.txt',$tpp);
}
if($city != ''){
$eagle_tm = file_get_contents('type.txt');
$txt = "دمای شهر$city هم اکنون$deg درجه سانتی گراد می باشد

شرایط فعلی آب و هوا: $eagle_tm";
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$txt]);
unlink('type.txt');
}else{
$txt = "⚠️شهر مورد نظر شما يافت نشد";
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$txt]);
}
}
elseif(preg_match("/^[\/\#\!]?(sessions)$/i",$text)){
$authorizations = yield $this->account->getAuthorizations();
$txxt="";
foreach($authorizations['authorizations'] as$authorization){
$txxt .="
هش: ".$authorization['hash']."
مدل دستگاه: ".$authorization['device_model']."
سیستم عامل: ".$authorization['platform']."
ورژن سیستم: ".$authorization['system_version']."
api_id: ".$authorization['api_id']."
app_name: ".$authorization['app_name']."
نسخه برنامه: ".$authorization['app_version']."
تاریخ ایجاد: ".date("Y-m-d H:i:s",$authorization['date_active'])."
تاریخ فعال: ".date("Y-m-d H:i:s",$authorization['date_active'])."
آی‌پی: ".$authorization['ip']."
کشور: ".$authorization['country']."
منطقه: ".$authorization['region']."

====================";
}
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$txxt]);
}
if(preg_match("/^[\/\#\!]?(gpinfo)$/i",$text)){
$peer_inf = yield $this->getFullInfo($message['to_id']);
$peer_info = $peer_inf['Chat'];
$peer_id = $peer_info['id'];
$peer_title = $peer_info['title'];
$peer_type = $peer_inf['type'];
$peer_count = $peer_inf['full']['participants_count'];
$des = $peer_inf['full']['about'];
$mes = "ID: $peer_id \nTitle: $peer_title \nType: $peer_type \nMembers Count: $peer_count \nBio: $des";
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$mes]);
}
}
if($data['power'] == "on"){
if($fromId != $me_id){
if($message and $data['typing'] == "on" and $update['_'] == "updateNewChannelMessage"){
$sendMessageTypingAction = ['_' => 'sendMessageTypingAction'];
yield $this->messages->setTyping(['peer' =>$peer, 'action' =>$sendMessageTypingAction]);
}
if($message and $data['echo'] == "on"){
yield $this->messages->forwardMessages(['from_peer' =>$peer, 'to_peer' =>$peer, 'id' => [$message['id']]]);
}
if($message and $data['markread'] == "on"){
if(intval($peer) < 0){
yield $this->channels->readHistory(['channel' =>$peer, 'max_id' =>$message['id']]);
yield $this->channels->readMessageContents(['channel' =>$peer, 'id' => [$message['id']] ]);
}else{
yield $this->messages->readHistory(['peer' =>$peer, 'max_id' =>$message['id']]);
}
}
if(strpos($text, '😐') !== false and $data['poker'] == "on"){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' => '😐', 'reply_to_msg_id' =>$message['id']]);
}
$fohsh = [
"گص کش","کس ننه","کص ننت","کس خواهر","کس خوار","کس خارت","کس ابجیت","کص لیس","ساک بزن","ساک مجلسی","ننه الکسیس","نن الکسیس","ناموستو گاییدم","ننه زنا","کس خل","کس مخ","کس مغز","کس مغذ","خوارکس","خوار کس","خواهرکس","خواهر کس","حروم زاده","حرومزاده","خار کس","تخم سگ","پدر سگ","پدرسگ","پدر صگ","پدرصگ","ننه سگ","نن سگ","نن صگ","ننه صگ","ننه خراب","تخخخخخخخخخ","نن خراب","مادر سگ","مادر خراب","مادرتو گاییدم","تخم جن","تخم سگ","مادرتو گاییدم","ننه حمومی","نن حمومی","نن گشاد","ننه گشاد","نن خایه خور","تخخخخخخخخخ","نن ممه","کس عمت","کس کش","کس بیبیت","کص عمت","کص خالت","کس بابا","کس خر","کس کون","کس مامیت","کس مادرن","مادر کسده","خوار کسده","تخخخخخخخخخ","ننه کس","بیناموس","بی ناموس","شل ناموس","سگ ناموس","ننه جندتو گاییدم باو ","چچچچ نگاییدم سیک کن پلیز D:","ننه حمومی","چچچچچچچ","لز ننع","ننه الکسیس","کص ننت","بالا باش","ننت رو میگام","کیرم از پهنا تو کص ننت","مادر کیر دزد","ننع حرومی","تونل تو کص ننت","کیر تک تک بکس تلع گلد تو کص ننت","کص خوار بدخواه","خوار کصده","ننع باطل","حروم لقمع","ننه سگ ناموس","منو ننت شما همه چچچچ","ننه کیر قاپ زن","ننع اوبی","ننه کیر دزد","ننه کیونی","ننه کصپاره","زنا زادع","کیر سگ تو کص نتت پخخخ","ولد زنا","ننه خیابونی","هیس بع کس حساسیت دارم","کص نگو ننه سگ که میکنمتتاااا","کص نن جندت","ننه سگ","ننه کونی","ننه زیرابی","بکن ننتم","ننع فاسد","ننه ساکر","کس ننع بدخواه","نگاییدم","مادر سگ","ننع شرطی","گی ننع","بابات شاشیدتت چچچچچچ","ننه ماهر","حرومزاده","ننه کص","کص ننت باو","پدر سگ","سیک کن کص ننت نبینمت","کونده","ننه ولو","ننه سگ","مادر جنده","کص کپک زدع","ننع لنگی","ننه خیراتی","سجده کن سگ ننع","ننه خیابونی","ننه کارتونی","تکرار میکنم کص ننت","تلگرام تو کس ننت","کص خوارت","خوار کیونی","پا بزن چچچچچ","مادرتو گاییدم","گوز ننع","کیرم تو دهن ننت","ننع همگانی","کیرم تو کص زیدت","کیر تو ممهای ابجیت","ابجی سگ","کس دست ریدی با تایپ کردنت چچچ","ابجی جنده","ننع سگ سیبیل","بده بکنیم چچچچ","کص ناموس","شل ناموس","ریدم پس کلت چچچچچ","ننه شل","ننع قسطی","ننه ول","دست و پا نزن کس ننع","ننه ولو","خوارتو گاییدم","محوی!؟","ننت خوبع!؟","کس زنت","شاش ننع","ننه حیاطی /:","نن غسلی","کیرم تو کس ننت بگو مرسی چچچچ","ابم تو کص ننت :/","فاک یور مادر خوار سگ پخخخ","کیر سگ تو کص ننت","کص زن","ننه فراری","بکن ننتم من باو جمع کن ننه جنده /:::","ننه جنده بیا واسم ساک بزن","حرف نزن که نکنمت هااا :|","کیر تو کص ننت😐","کص کص کص ننت😂","کصصصص ننت جووون","سگ ننع","کص خوارت","کیری فیس","کلع کیری","تیز باش سیک کن نبینمت","فلج تیز باش چچچ","بیا ننتو ببر","بکن ننتم باو ","کیرم تو بدخواه","چچچچچچچ","ننه جنده","ننه کص طلا","ننه کون طلا","کس ننت بزارم بخندیم!؟","کیرم دهنت","مادر خراب","ننه کونی","هر چی گفتی تو کص ننت خخخخخخخ","کص ناموست بای","کص ننت بای ://","کص ناموست باعی تخخخخخ","کون گلابی!","ریدی آب قطع","کص کن ننتم کع","نن کونی","نن خوشمزه","ننه لوس"," نن یه چشم ","ننه چاقال","ننه جینده","ننه حرصی ","نن لشی","ننه ساکر","نن تخمی","ننه بی هویت","نن کس","نن سکسی","نن فراری","لش ننه","سگ ننه","شل ننه","ننه تخمی","ننه تونلی","ننه کوون","نن خشگل","نن جنده","نن ول ","نن سکسی","نن لش","کس نن ","نن کون","نن رایگان","نن خاردار","ننه کیر سوار","نن پفیوز","نن محوی","ننه بگایی","ننه بمبی","ننه الکسیس","نن خیابونی","نن عنی","نن ساپورتی","نن لاشخور","ننه طلا","ننه عمومی","ننه هر جایی","نن دیوث","تخخخخخخخخخ","نن ریدنی","نن بی وجود","ننه سیکی","ننه کییر","نن گشاد","نن پولی","نن ول","نن هرزه","نن دهاتی","ننه ویندوزی","نن تایپی","نن برقی","نن شاشی","ننه درازی","شل ننع","یکن ننتم که","کس خوار بدخواه","آب چاقال","ننه جریده","ننه سگ سفید","آب کون","ننه 85","ننه سوپری","بخورش","کس ن","خوارتو گاییدم","خارکسده","گی پدر","آب چاقال","زنا زاده","زن جنده","سگ پدر","مادر جنده","ننع کیر خور","چچچچچ","تیز بالا","ننه سگو با کسشر در میره","کیر سگ تو کص ننت","kos kesh","kir","kiri","nane lashi","kos","kharet","blis kirmo","دهاتی","کیرم لا کص خارت","کیری","ننه لاشی","ممه","کص","کیر","بی خایه","ننه لش","بی پدرمادر","خارکصده","مادر جنده","کصکش"
];
if(in_array($fromId,$data['enemies'])){
$f = $fohsh[rand(0, count($fohsh)-1)];
yield $this->messages->deleteMessages(['revoke' => 'Bool','peer' =>$peer,'id' => [$msg_id]]);
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$f, 'reply_to_msg_id' =>$msg_id]);
}
if(isset($data['answering'][$text])){
yield $this->messages->sendMessage(['peer' =>$peer, 'message' =>$data['answering'][$text] , 'reply_to_msg_id' =>$msg_id]);
}
}
}
}
} catch (\Throwable $e){
$this->report("Surfaced: $e");
}
}
}
$settings = [
'app_info' => [
'api_id' => "8281216",
'api_hash' => "04b7adce378eb603f36b2855cb7b734f"
],
'serialization' => [
'cleanup_before_serialization' => true,
],
'logger' => [
'max_size' => 1*1024*1024,
],
'peer' => [
'full_fetch' => false,
'cache_all_peers_on_startup' => false,
]
];
// ﴾ ! @Sourrce_Kade ! ﴿ // اسکی با زدن منبع آزاد //
$bot = new \danog\MadelineProto\API('X.session', $settings);
$bot->startAndLoop(XHandler::class);
?>