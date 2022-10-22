import cv2
import numpy
import sys

def readImage(fileName):
	result = cv2.imread(fileName)
	if (result is None):
		sys.exit("File not found")

	return result

def showImage(title, image):
	cv2.namedWindow(title, cv2.WINDOW_NORMAL)
	cv2.imshow(title, image)

def getSlice(image, size, index):
	startIndex = size * index
	endIndex = size * (index + 1)
	return image[startIndex:endIndex, 0:image.shape[1], index]

def showProperties(image):
	print("Image propertoes:")
	print("  Shape: " + str(image.shape))
	print("   Height: " + str(image.shape[0]))
	print("   Width: " + str(image.shape[1]))

image = readImage("image.jpg")
showProperties(image)

sliceSize = int(image.shape[0] / 3)
slice0 = getSlice(image, sliceSize, 0)
slice1 = getSlice(image, sliceSize, 1)
slice2 = getSlice(image, sliceSize, 2)

slice0 = numpy.roll(slice0, -2, 0)
# slice1 = numpy.roll(slice1, -2, 0)
slice2 = numpy.roll(slice2, 12, 0)

grouped = numpy.dstack((slice0, slice1, slice2))

showImage("B", slice0)
showImage("G", slice1)
showImage("R", slice2)
showImage("RGB", grouped)

cv2.waitKey(0)
cv2.destroyAllWindows()
