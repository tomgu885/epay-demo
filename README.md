# epay-demo, 对接演示

## 签名
1. 所有请求都是 post json
2. 将json 里的参数按key的 字母顺序排列，再连起来
3. 再 将 api_key 附加 上面获得字符串后面，进行 sha1 hash 获得 $sign 字符串
4. 将 api_id 和 
