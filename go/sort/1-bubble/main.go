package main

import "fmt"

func main() {
	arr := []int{1, 3, 45, 32, 74, 33, 22, 8, 23, 75, 44, 26, 9}
	result := bubbleSort(arr)
	fmt.Println(result)
}

func bubbleSort(arr []int) []int {
	for i := 0; i < len(arr)-1; i++ {
		for j := 0; j < len(arr)-1-i; j++ {
			//相邻元素两两对比
			if arr[j] > arr[j+1] {
				// 元素交换
				temp := arr[j+1]
				arr[j+1] = arr[j]
				arr[j] = temp
			}
		}
	}
	return arr
}
