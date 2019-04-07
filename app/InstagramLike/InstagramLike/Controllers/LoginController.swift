//
//  LoginController.swift
//  InstagramLike
//
//  Created by Jonathan Meslien on 26/03/2019.
//  Copyright © 2019 Jonathan Meslien. All rights reserved.
//

import UIKit

class LoginController: UIViewController {
    
    @IBOutlet weak var Inscription: UIButton!
    @IBOutlet weak var Password: UITextField!
    @IBOutlet weak var Email: UITextField!
    @IBOutlet weak var Name: UITextField!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        let gradientLayer = CAGradientLayer()
        gradientLayer.transform = CATransform3DMakeRotation(90.0 / 180.0 * .pi, 0, 0, 1)
        gradientLayer.frame = self.view.bounds
        gradientLayer.colors = [CustomOrange.cgColor, CustomPink.cgColor]
        self.view.layer.insertSublayer(gradientLayer, at: 0)
        self.Inscription.backgroundColor = BLUE
        self.Email.placeholder = EMAIL_TEXT
        self.Password.placeholder = PASSWORD_TEXT
        self.Name.placeholder = NAME_TEXT
    }
    
    
}


