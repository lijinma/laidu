<?php

namespace App\Http\Controllers;

use App\InviteCode;
use App\RollCode;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        \Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        /** @var Application $wechat */
        $wechat = app('wechat');
        $user = $wechat->user;
        $wechat->server->setMessageHandler(function ($message) use ($user) {
            if ($message->MsgType == 'text' && strpos($message->Content, '邀请') !== false) {
                $code = InviteCode::getCodeForOpenid($message->FromUserName);
                return '邀请码：' . $code . " \n\n继续注册请点击：http://laidu.co/register?code=" . $code;
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '地图') !== false) {
                return '财富地图： http://xiaolai.co/map';
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '区块链') !== false) {
                return '【金马带你定投区块链】普通人如何投资区块链： http://mp.weixin.qq.com/s/CXXq4Do_8IJEQNEQinu5aw';
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '星云') !== false) {
                return '
【私募信息】

项目： 星云链

轮次： 私募 早鸟轮

截至： 12月14日18点

星云链是做什么的呢？一句话介绍就是建立在区块链价值新维度上的搜索引擎。它是区块链3.0的产品，是在基于数字资产（区块链1.0，比特币）和去中心化应用（区块链2.0，以太坊），在价值尺度上做的一个新的探索。具体信息喝白皮书见官网。

官方网站： https://nebulas.io/cn/

介绍星云链的文章：
http://mp.weixin.qq.com/s/5mYXgy2pilZEt2bKvFVhbg


非白皮书：https://nebulas.io/docs/NebulasWhitepaperZh.pdf

白皮书：https://nebulas.io/docs/NebulasTechnicalWhitepaperZh.pdf

项目代码：https://github.com/nebulasio

创始人： 徐义吉. 创始人. 星云链（Nebulas）& 小蚁（NEO）创始人，前蚂蚁金服区块链平台部负责人，前谷歌反作弊小组成员。

门槛：5ETH（如果你转账小于 5eth，不会返回代币，也不退回）

超过1000 ETH， 奖励5% NAS，奖励的 NAS 分六个月分发。

代币比例：按美元比例，按ETH结算。1NAS = 2美元（具体会按照纽约时间 6:00 am coinmarketcap.com ETH 价格为准）

预计12月底项目方私募结束发币，不锁币，2018年1月上线交易所。

已确认交易所：火币，Allcoin，Bcex，Lbank等

代投费：无代投费

转账地址：0x6eD30670bE625389F5550a9792AE76beB3Dd4a5a （4a5a 结尾）

「「提醒」」：必须是用钱包（imToken）转账，因为接受代币就是你打币的地址。

如果你仍然强制要通过交易所打币，请及时联系我，会收取你投资金额的 50%  作为操作费用，不开玩笑。

投资有风险，不保证一定盈利，各位伙伴为自己投资负责。
                ';
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '故事') !== false) {
                return '讲个故事给你听：当金马搭载上火箭……： http://mp.weixin.qq.com/s/q0gRGghGuNT4owd__B_cwQ';
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '007') !== false) {
                return '不写就出局：http://wechat.buchuju.net/#/relate/1717';
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '留言') !== false) {
                return '财富留言榜：http://caifu.xiaolai.co';
            }
            if ($message->MsgType == 'text' && strpos($message->Content, '金马') !== false) {
                return '我叫李金马，上海工作，程序员，持续学习者。
                
做了一个关于区块链的社群，名字叫"金马带你定投区块链"，带领小白进入区块链的大门，http://t.xiaomiquan.com/QfMZb6u。

【新】我在帮380多人定投区块链（btc eth eos zec bch），帮你节省时间， http://mp.weixin.qq.com/s/8t5O6XIhykUkfGuqseht1g
                
上线了一个产品“来读” http://laidu.co，可以上传电子书，可以像读书一样读公众号，另外，通过全文检索来获取需要的写作素材，可以说是升级版”笑来搜“

写过一个小工具“笑来搜”  http://xiaolai.co 解决了同学们通过关键字搜索笑来老师的书和文章。

写了一个小工具"财富留言榜" http://caifu.xiaolai.co 方便大家通过昵称来查看自己在《通往财富自由之路》的留言。

笑来搜原型开源了，可以查看 https://github.com/lijinma/laravel-scout-elastic-demo  你可以自己也搭建一个自定义的搜索站

持续英文朗读300多天了，我的录音 http://m.ximalaya.com/38523311/album/4640395

从2017年开始每周一篇文章。

我最大的优点是“会鼓励别人“，因为自己也需要鼓励，所以如果你需要鼓励，可以加我微信 lijinma2 ';
            }
            if ($message->MsgType == 'event' && $message->Event == 'subscribe') {
                return '谢谢你的关注，我是金马。

了解我，回复"金马"

想听我的故事，回复"故事"

【金马带你定投区块链】了解普通人如何投资区块链，回复"区块链"

想加入007不写就出局，回复"007"

想使用财富留言榜，回复"留言"

获取 http://laidu.co 的邀请码，回复"邀请码"';
            }
            return '';
        });

        \Log::info('return response.');

        return $wechat->server->serve();
    }
}
