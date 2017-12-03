using UnityEngine;
using System.Collections;

public class joinGame_click : MonoBehaviour {
    public GameObject ws;
	// Use this for initialization
	void Start () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        //waitS.SetActive(true);

    }
	
	// Update is called once per frame
	public void butpress () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        ws.SetActive(true);

    }
}
