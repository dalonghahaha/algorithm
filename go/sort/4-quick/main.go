package main

import "fmt"

func main() {
	arr := []int{3, 1, 45, 32, 74, 33, 22, 8, 23, 75, 44, 26, 9}
	result := quickSort(arr)
	fmt.Println(result)
}

func quickSort(arr []int) []int {
	length := len(arr)
	if length <= 1 {
		return arr
	}
	//设定基数
	middle := arr[0]
	left := []int{}
	right := []int{}
	//划分区间，左边都比中位数小，右边都比中位数大
	for i := 1; i < length; i++ {
		if middle < arr[i] {
			right = append(right, arr[i])
		} else {
			left = append(left, arr[i])
		}
	}
	//左边区间递归进行快速排序
	left = quickSort(left)
	//右边区间递归进行快速排序
	right = quickSort(right)
	result := append(append(left, middle), right...)
	return result
}
