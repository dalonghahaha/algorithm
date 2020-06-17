package main

import "fmt"

func main() {
	arr := []int{1, 3, 45, 32, 74, 33, 22, 8, 23, 75, 44, 26, 9}
	result := selectionSort(arr)
	fmt.Println(result)
}

func selectionSort(arr []int) []int {
	var minIndex, temp int
	for i := 0; i < len(arr)-1; i++ {
		minIndex = i
		for j := i + 1; j < len(arr); j++ {
			// 寻找最小的数,将最小数的索引保存
			if arr[j] < arr[minIndex] {
				minIndex = j
			}
		}
		//将最小数放到当前的遍历位置
		temp = arr[i]
		arr[i] = arr[minIndex]
		arr[minIndex] = temp
	}
	return arr
}
