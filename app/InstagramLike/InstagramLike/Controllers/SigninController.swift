//
//  SigninController.swift
//  InstagramLike
//
//  Created by Jonathan Meslien on 25/03/2019.
//  Copyright © 2019 Jonathan Meslien. All rights reserved.
//

import UIKit

class SigninController: UIViewController {
    
    @IBOutlet weak var LogIn: UIButton!
    @IBOutlet weak var SignUp: UIButton!
    override func viewDidLoad() {
        super.viewDidLoad()
        let CustomPink = UIColor(red:0.96, green:0.29, blue:0.39, alpha:1.0)
        let CustomOrange = UIColor(red:0.97, green:0.51, blue:0.38, alpha:1.0)
        let gradientLayer = CAGradientLayer()
        gradientLayer.transform = CATransform3DMakeRotation(90.0 / 180.0 * .pi, 0, 0, 1)
        gradientLayer.frame = self.SignUp.bounds
        gradientLayer.colors = [CustomOrange.cgColor, CustomPink.cgColor]
        self.SignUp.layer.addSublayer(gradientLayer)
        let radiusLogIn: CGFloat = self.LogIn.bounds.size.height / 2.3
        let radiuSignUp: CGFloat = self.SignUp.bounds.size.height / 2.3
        self.LogIn.layer.cornerRadius = radiusLogIn
        self.LogIn.clipsToBounds = true
        self.SignUp.layer.cornerRadius = radiuSignUp
        self.SignUp.clipsToBounds = true
    }
    
    
}

