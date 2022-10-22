import cv2
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

image = readImage("RGBLabels.jpg")
showImage("R", image[:, :, 2])
showImage("G", image[:, :, 1])
showImage("B", image[:, :, 0])
