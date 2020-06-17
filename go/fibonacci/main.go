package main

import "fmt"

func main() {
	result := fibonacci(10)
	fmt.Println("fibonacci result:", result)
	result = fibonacci_recursive(10)
	fmt.Println("fibonacci with recursive result:", result)
}

func fibonacci(n int) int {
	if n < 1 {
		panic("invalid arguments")
	}
	if n == 1 || n == 2 {
		return 1
	}
	a := 1
	b := 1
	res := 0
	for i := 3; i <= n; i++ {
		res = a + b
		a = b
		b = res
	}
	return res
}

func fibonacci_recursive(n int) int {
	if n < 1 {
		panic("invalid arguments")
	}
	if n == 1 || n == 2 {
		return 1
	}
	return fibonacci_recursive(n-1) + fibonacci_recursive(n-2)
}
