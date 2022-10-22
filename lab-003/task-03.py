import cv2
import sys

def readImage(fileName):
	result = cv2.imread(fileName)
	if (result is None):
		sys.exit("File not found")

	return result

def showImage(title, image):
	cv2.namedWindow(title, cv2.WINDOW_NORMAL)
	cv2.imshow(title, image)
	cv2.waitKey(0)
	cv2.destroyAllWindows()

image = readImage("RGBMixed_Colors.jpg")
showImage("Source", image)

hsv = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)
[h, s, v] = cv2.split(hsv)
showImage("HSV", hsv)
showImage("Channel H", h)
showImage("Channel S", s)
showImage("Channel V", v)
