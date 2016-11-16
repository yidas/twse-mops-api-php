<?php

/**
* 
*/
class API
{
    /**
     * Fetch IncomeStatement
     *
     * @param int $stockID
     * @return string HTML from TWSE
     */
    public static function fetchIncomeStatement($stockID)
    {
        if (!$stockID) {
            return false;
        }

        // URL for IncomeStatement
        $apiUrl = "http://mops.twse.com.tw/mops/web/ajax_t163sb15";

        // Post params
        $originParams = "encodeURIComponent=1&firstin=1&off=1&keyword4=&code1=&TYPEK2=&checkbtn=&queryName=co_id&t05st29_c_ifrs=N&t05st30_c_ifrs=N&TYPEK=all&isnew=true&co_id=3339&year=";

        // Parse to array
        parse_str($originParams, $params);

        // 1 or 2(2-Level that the default is parent company)
        $params['step'] = 2;

        // Stock ID
        $params['co_id'] = $stockID;

        return self::curl($apiUrl, $params);
    }

    /**
     * Curl
     *
     * @param string $url
     * @param array $params
     */
    private static function curl($url, $params)
    {
        $paramsQuery = http_build_query($params);

        // 建立CURL連線
        $ch = curl_init();

        // 設定擷取的URL網址
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        //設定CURLOPT_POST 為 1或true，表示要用POST方式傳遞
        curl_setopt($ch, CURLOPT_POST, 1); 
        //CURLOPT_POSTFIELDS 後面則是要傳接的POST資料。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsQuery);

        // 執行
        $result = curl_exec($ch);

        // 關閉CURL連線
        curl_close($ch);

        return $result;
    }
}



