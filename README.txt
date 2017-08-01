支付宝支付说明文档

/////////////////////////////////////////////////////////////////////////////////
//支付类的使用方法
$Pay = new \Alipay\Api\Pay();
$Pay->total_amount = '';//支付金额，精确到小数点后两位
$Pay->subject = '';//订单标题
$Pay->body = '';//订单详情
$Pay->out_trade_no = '' ;//商户网站唯一订单号
$Pay->notify_url = "";//支付成功的回调地址
$respont = $Pay->Request();//发起请求
////////////////////////////////////////////////////////////////////////////////
退款接口
$Refund = new \Alipay\Api\Refund();
$Refund->out_trade_no = '' ;//商户订单号
$Refund->trade_no = ' ';//支付宝交易号
$Refund->refund_amount = '' ;/退款的金额
$Refund->refund_reason = '';//退款的原因
$Refund->out_request_no = '' ;//标识一次退款请求
$Refund->operator_id = '';//商户的操作员
$respond = $Refund->Request();

///////////////////////////////////////////////////////////////////////////
统一收单交易退款查询
$QueryRefund = new \Alipay\Api\QueryRefund();
$QueryRefund->trade_no = '' ;//支付宝交易号
$QueryRefund->out_trade_no = '' ;//商家订单号
$QueryRefund->out_request_no = '';//退款请求号
$respond = $QueryRefund->Request();

////////////////////////////////////////////////////////////////////
统一收单线下交易查询
$TradeQuery = new \Alipay\Api\TradeQuery();
$TradeQuery->out_trade_no = '' ;//商户订单号
$TradeQuery->trade_no = '' ;//支付宝交易号
$respont = $TradeQuery->Request();

///////////////////////////////////////////////////////////////////
单笔转账到支付宝账户接口
$TransToaccount = new \Alipay\Api\TransToaccount();
$TransToaccount->out_biz_no = '';//商户订单号
$TransToaccount->pay_account = '';//收款方账号,手机号，或者邮箱
$TransToaccount->amount = '';//转账金额
$TransToaccount->remark = '';//转账备注
$respond = $TransToaccount->Request();

////////////////////////////////////////////////////////////////
单笔转账查询接口
$OrderQuery = new \Alipay\Api\OrderQuery();
$OrderQuery->out_biz_no = '';//商户转账单号，这个和下面的任意填写一个就好了
$OrderQuery->order_id = '';//支付宝转账单据号
$respond = $OrderQuery->Request();

