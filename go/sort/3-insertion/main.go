package main

import "fmt"

func main() {
	arr := []int{3, 1, 45, 32, 74, 33, 22, 8, 23, 75, 44, 26, 9}
	result := insertionSort(arr)
	fmt.Println(result)
}

func insertionSort(arr []int) []int {
	for i := 1; i < len(arr); i++ {
		current := arr[i]
		index := i
		//从前一位开始遍历
		for j := i - 1; j >= 0; j-- {
			//如果前一位的数值比当前的小，则将前一位的数赋值到当前位
			if arr[j] > current {
				//将前一位的数赋值到当前位
				arr[j+1] = arr[j]
				//将前一位的索引设置为当前数值应该存在的位置
				index = j
			} else {
				break
			}
		}
		arr[index] = current
	}
	return arr
}
