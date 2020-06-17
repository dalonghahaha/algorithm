package main

import "fmt"

func main() {
	arr := []int{3, 1, 45, 32, 74, 33, 22, 8, 23, 75, 44, 26, 9}
	result := countingSort(arr)
	fmt.Println(result)
}

func countingSort(arr []int) []int {
	maxValue := arr[0]
	//找到最大值
	for _, val := range arr {
		if val > maxValue {
			maxValue = val
		}
	}
	//初始化计数桶
	bucketLen := maxValue + 1
	bucket := make([]int, bucketLen)
	//入桶
	for _, val := range arr {
		bucket[val] += 1
	}
	//获取排序结果
	sortedIndex := 0
	for j := 0; j < bucketLen; j++ {
		for bucket[j] > 0 {
			arr[sortedIndex] = j
			sortedIndex += 1
			bucket[j] -= 1
		}
	}
	return arr
}
