/**
 * BinFileReader.js
 * You can find more about this function at
 * http://nagoon97.com/reading-binary-files-using-ajax/
 *
 * Copyright (c) 2008 Andy G.P. Na <nagoon97@naver.com>
 * The source code is freely distributable under the terms of an MIT-style license.
 */
function BinFileReader(fileURL) {
    var _exception = {};
    _exception.FileLoadFailed = 1;
    _exception.EOFReached = 2;

    var filePointer = 0;
    var fileSize = -1;
    var fileContents;

    this.getFileSize = function () {
        return fileSize;
    }

    this.getFilePointer = function () {
        return filePointer;
    }

    this.movePointerTo = function (iTo) {
        if (iTo < 0) filePointer = 0;
        else if (iTo > this.getFileSize()) throwException(_exception.EOFReached);
        else filePointer = iTo;

        return filePointer;
    };

    this.movePointer = function (iDirection) {
        this.movePointerTo(filePointer + iDirection);

        return filePointer;
    };

    this.readNumber = function (iNumBytes, iFrom) {
        iNumBytes = iNumBytes || 1;
        iFrom = iFrom || filePointer;

        this.movePointerTo(iFrom + iNumBytes);

        var result = 0;
        for (var i = iFrom + iNumBytes; i > iFrom; i--) {
            result = result * 256 + this.readByteAt(i - 1);
        }

        return result;
    };

    this.readString = function (iNumChars, iFrom) {
        iNumChars = iNumChars || 1;
        iFrom = iFrom || filePointer;

        this.movePointerTo(iFrom);

        var result = "";
        var tmpTo = iFrom + iNumChars;
        for (var i = iFrom; i < tmpTo; i++) {
            result += String.fromCharCode(this.readNumber(1));
        }

        return result;
    };

    this.readUnicodeString = function (iNumChars, iFrom) {
        iNumChars = iNumChars || 1;
        iFrom = iFrom || filePointer;

        this.movePointerTo(iFrom);

        var result = "";
        var tmpTo = iFrom + iNumChars * 2;
        for (var i = iFrom; i < tmpTo; i += 2) {
            result += String.fromCharCode(this.readNumber(2));
        }

        return result;
    };

    function throwException(errorCode) {
        switch (errorCode) {
            case _exception.FileLoadFailed:
                throw new Error('Error: Filed to load "' + fileURL + '"');
                break;
            case _exception.EOFReached:
                throw new Error("Error: EOF reached");
                break;
        }
    }

    function BinFileReaderImpl(fileURL) {
        fileContents = atob(log);
        fileSize = fileContents.length;

        this.readByteAt = function (i) {
            return fileContents.charCodeAt(i) & 0xff;
        }
    }

    BinFileReaderImpl.apply(this, [fileURL]);
}
