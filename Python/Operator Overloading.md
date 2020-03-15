# Operator Overloading





```python
import math

class Point:

    def __init__(self, xCoord=0, yCoord=0):
        self.__xCoord = xCoord
        self.__yCoord = yCoord

    # get x coordinate
    def get_xCoord(self):
        return self.__xCoord

    # set x coordinate
    def set_xCoord(self, xCoord):
        self.__xCoord = xCoord

    # get y coordinate
    def get_yCoord(self):
        return self.__yCoord

    # set y coordinate
    def set_yCoord(self, yCoord):
        self.__yCoord = yCoord

    # get current position
    def get_position(self):
        return self.__xCoord, self.__yCoord

    # change x & y coordinates by p & q
    def move(self, p, q):
        self.__xCoord += p
        self.__yCoord += q

    # overload + operator
    def __add__(self, point_ov):
        return Point(self.__xCoord + point_ov.__xCoord, self.__yCoord + point_ov.__yCoord)

    # overload - operator
    def __sub__(self, point_ov):
        return Point(self.__xCoord - point_ov.__xCoord, self.__yCoord - point_ov.__yCoord)

    # overload < (less than) operator
    def __lt__(self, point_ov):
        return math.sqrt(self.__xCoord ** 2 + self.__yCoord ** 2) < math.sqrt(point_ov.__xCoord ** 2 + point_ov.__yCoord ** 2)

    # overload > (greater than) operator
    def __gt__(self, point_ov):
        return math.sqrt(self.__xCoord ** 2 + self.__yCoord ** 2) > math.sqrt(point_ov.__xCoord ** 2 + point_ov.__yCoord ** 2)

    # overload <= (less than or equal to) operator
    def __le__(self, point_ov):
        return math.sqrt(self.__xCoord ** 2 + self.__yCoord ** 2) <= math.sqrt(point_ov.__xCoord ** 2 + point_ov.__yCoord ** 2)

    # overload >= (greater than or equal to) operator
    def __ge__(self, point_ov):
        return math.sqrt(self.__xCoord ** 2 + self.__yCoord ** 2) >= math.sqrt(point_ov.__xCoord ** 2 + point_ov.__yCoord ** 2)

    # overload == (equal to) operator
    def __eq__(self, point_ov):
        return math.sqrt(self.__xCoord ** 2 + self.__yCoord ** 2) == math.sqrt(point_ov.__xCoord ** 2 + point_ov.__yCoord ** 2)
```

