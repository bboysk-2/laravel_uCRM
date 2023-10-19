const nl2br = (str) => {
   var str = str.replace(/\r\n/g, "<br>");
    str = str.replace(/(\n|\r)/g, "<br>");
    return str;
}

//  関数を他のファイルから使用できるようにエクスポート
export { nl2br }
