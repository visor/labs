import cv2
import numpy
import sys

def readImage(fileName):
	result = cv2.imread(fileName)
	if (result is None):
		sys.exit("Файл изображения не найден")

	return result

def showImage(title, image):
	cv2.namedWindow(title, cv2.WINDOW_NORMAL)
	cv2.imshow(title, image)
	cv2.waitKey(0)
	cv2.destroyAllWindows()

def getSlice(image, size, index, startOffset = 0, endOffset = 0):
	startIndex = size * index + startOffset;
	endIndex = size * (index + 1) + endOffset;
	result = image[startIndex:endIndex, 0:image.shape[1]]

	if (startOffset > 0 or endOffset > 0):
		result = cv2.copyMakeBorder(result,
			top = startOffset,
			bottom = endOffset,
			left = 0,
			right = 0,
			borderType = cv2.BORDER_CONSTANT,
			value = [0, 0, 0]
		)

	return result

def getChannelSlice(image, size, index, startOffset = 0, endOffset = 0):
	startIndex = size * index + startOffset;
	endIndex = size * (index + 1) + endOffset;
	result = image[startIndex:endIndex, 0:image.shape[1]]

	if (startOffset > 0 or endOffset > 0):
		result = cv2.copyMakeBorder(result,
			top = startOffset,
			bottom = endOffset,
			left = 0,
			right = 0,
			borderType = cv2.BORDER_CONSTANT,
			value = [0, 0, 0]
		)

	return result

def showProperties(image):
	print("Свойства изображения:")
	print("  Размеры: " + str(image.shape))
	print("   Высота: " + str(image.shape[0]))
	print("   Ширина: " + str(image.shape[1]))
	print("   Каналы: " + str(image.shape[2]))
	print("Общее количество элементов: " + str(image.size))
	print("Вид изображения: " + str(image.dtype))

image = readImage("image.jpg")
showProperties(image)

sliceSize = int(image.shape[0] / 3)
slice0 = getSlice(image, sliceSize, 0)
slice1 = getSlice(image, sliceSize, 1)
slice2 = getSlice(image, sliceSize, 2, 10)

# Вариант 1
# grouped = slice0 + slice1 + slice2

# Вариант 2
grouped = cv2.add(slice0, slice1)
grouped = cv2.add(grouped, slice2)

# Вариант 3
# grouped = numpy.zeros((sliceSize, image.shape[1], image.shape[2]), dtype = numpy.uint8);
# grouped[:sliceSize, :slice0.shape[1]] += slice0[:sliceSize, :slice0.shape[1]]
# grouped[:sliceSize, :slice1.shape[1]] += slice1[:sliceSize, :slice1.shape[1]]
# grouped[:sliceSize, :slice2.shape[1]] += slice2[:sliceSize, :slice2.shape[1]]

# Вариант 4
# grouped = numpy.zeros((sliceSize, image.shape[1], image.shape[2]), dtype = numpy.uint8);
# grouped[:, :, 0] = slice0;
# grouped[:, :, 1] = slice1;
# grouped[:, :, 2] = slice2;

showImage("Кадр №1", slice0)
showImage("Кадр №2", slice1)
showImage("Кадр №3", slice2)
showImage("Наложение", grouped)