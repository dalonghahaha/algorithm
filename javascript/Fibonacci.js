//递归解法
function fib(n){
    if(n < 1){
        throw new Error('invalid arguments');
    }
    if(n == 1 || n == 2){
        return 1;
    }
    return fib(n - 1) + fib(n - 2);
}
//非递归解法
function fib(n){
    if(n < 1){
        throw new Error('invalid arguments');
    }
    if(n == 1 || n == 2){
        return 1;
    }
    var a = 1,
        b = 1,
        res = 0;
    for(var i=3;i<=n;i++){
        res = a + b;
        a = b;
        b = res;
    }
    return res;
}
