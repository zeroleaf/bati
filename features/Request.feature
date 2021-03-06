#language: zh-CN
功能: 基于 Behat 的接口测试
  
  背景:
  
    * 在 http://inshop.com 域
  
  场景: 基本测试
    * 对于 GET 的 /test/echo 请求
    * 我在 id 中填入了 123
    * 我在 name 中填入了 {name}
    * 我提交了该请求
    
    * 则响应的状态码为 200
    * 则响应的状态码满足 /2\d{2}/
    
    * 响应数据中的 code 等于 0
    * 则响应数据中的 code 类型为 int
    * 则响应数据中的 data.id 为 123
    
    * 则响应的 Cookie cookie1 等于 cookie-value1