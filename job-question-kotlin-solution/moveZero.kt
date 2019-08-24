fun main(arguments: Array<String>) {
    val numbers = intArrayOf(0, 0, 0, 2, 0, 1, 3, 4, 0, 0);
    moveZero(numbers);
    for (element in numbers) {
        println(element)
    }
}

fun moveZero(numbers: IntArray) {
    var start = 0
    var end = 0
    for(num in numbers){
        if(num == 0){
            start++
        } else {
            swap(numbers, start, end)
            start++
            end++
        }
    }
}

fun swap(numbers: IntArray, sourceIndex: Int, targetIndex: Int) {
    numbers[sourceIndex] = numbers[targetIndex].also { numbers[targetIndex] = numbers[sourceIndex]}
}