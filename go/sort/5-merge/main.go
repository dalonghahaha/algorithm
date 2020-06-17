package main

import "fmt"

func main() {
	arr := []int{3, 1, 45, 32, 74, 33, 22, 8, 23, 75, 44, 26, 9}
	result := mergeSort(arr)
	fmt.Println(result)
}

func mergeSort(arr []int) []int {
	if len(arr) < 2 {
		return arr
	}
	i := len(arr) / 2
	left := mergeSort(arr[0:i])
	right := mergeSort(arr[i:])
	result := merge(left, right)
	return result
}

func merge(left, right []int) []int {
	result := make([]int, 0)
	m, n := 0, 0 // left和right的index位置
	l, r := len(left), len(right)
	for m < l && n < r {
		if left[m] > right[n] {
			result = append(result, right[n])
			n++
			continue
		}
		result = append(result, left[m])
		m++
	}
	result = append(result, right[n:]...)
	result = append(result, left[m:]...)
	return result
}
