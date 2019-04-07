//
//  hexToUiColor.swift
//  InstagramLike
//
//  Created by Jonathan Meslien on 26/03/2019.
//  Copyright © 2019 Jonathan Meslien. All rights reserved.
//

func HexToColor(hexString: String, alpha:CGFloat? = 1.0) -> UIColor {
    // Convert hex string to an integer
    let hexint = Int(self.intFromHexString(hexString))
    let red = CGFloat((hexint & 0xff0000) >> 16) / 255.0
    let green = CGFloat((hexint & 0xff00) >> 8) / 255.0
    let blue = CGFloat((hexint & 0xff) >> 0) / 255.0
    let alpha = alpha!
    // Create color object, specifying alpha as well
    let color = UIColor(red: red, green: green, blue: blue, alpha: alpha)
    return color
}
