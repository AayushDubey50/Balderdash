using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class camSript : MonoBehaviour {

    public int rnd;

    public string userID;
    public string gameID;
    public string userName;

    public string currWord  = "";

    public int pnum = 0;
    private int currP;

    public string[] p;
    public string[] scores;
    public string hardscores;
    public string[] d;
    public int[] dfv;

    private string p1 = "";
    private string p2 = "";
    private string p3 = "";
    private string p4 = "";
    private string p5 = "";
    private string p6 = "";

    private string s1 = "";
    private string s2 = "";
    private string s3 = "";
    private string s4 = "";
    private string s5 = "";
    private string s6 = "";

    private string d1 = "";
    private string d2 = "";
    private string d3 = "";
    private string d4 = "";
    private string d5 = "";
    private string d6 = "";

    private int dfv1;
    private int dfv2;
    private int dfv3;
    private int dfv4;
    private int dfv5;
    private int dfv6;



    // Use this for initialization
    void Start () {
        rnd = 1;
        Application.runInBackground = true;
        getUserID();




    }

    public int getPnum()
    {
        return pnum;
    }
        

    public string getCurrWord()
    {
        return currWord;
    }

    public string getID()
    {
        return userID;
    }

    public string getUserID()
    {
        return userID;
    }
    
    
    public void setID(string p)
    {
        userID = p;
    }
    
    public void setGameID(string gi)
    {
        gameID = gi;
    }

    public string getGameID()
    {
        return gameID;
    }



    // Update is called once per frame
	void Update () {
	
	}

    public int getRnd()
    {
        return rnd;
    }
    public void setRnd()
    {
        rnd++;
    }

    public string getP1()
    {
        return p1;
    }

    public void setP1(string p)
    {
        p1 = p;
    }

    public string getP2()
    {
        return p2;
    }

    public void setP2(string p)
    {
        p2 = p;
    }

    public string getP3()
    {
        return p3;
    }

    public void setP3(string p)
    {
        p3 = p;
    }

    public string getP4()
    {
        return p4;
    }

    public void setP4(string p)
    {
        p4 = p;
    }

    public string getP5()
    {
        return p5;
    }

    public void setP5(string p)
    {
        p5 = p;
    }


    public string getP6()
    {
        return p6;
    }

    public void setP6(string p)
    {
        p6 = p;
    }



    public string getS1()
    {
        return s1;
    }

    public void setS1(string p)
    {
        s1 = p;
    }

    public string getS2()
    {
        return s2;
    }

    public void setS2(string p)
    {
        s2 = p;
    }

    public string getS3()
    {
        return s3;
    }

    public void setS3(string p)
    {
        s3 = p;
    }

    public string getS4()
    {
        return s4;
    }

    public void setS4(string p)
    {
        s4 = p;
    }

    public string getS5()
    {
        return s5;
    }

    public void setS5(string p)
    {
        s5 = p;
    }


    public string getS6()
    {
        return s6;
    }

    public void setS6(string p)
    {
        s6 = p;
    }


    public string getD1()
    {
        return d1;
    }

    public void setD1(string p)
    {
        d1 = p;
    }

    public string getD2()
    {
        return d2;
    }

    public void setD2(string p)
    {
        d2 = p;
    }

    public string getD3()
    {
        return d3;
    }

    public void setD3(string p)
    {
        d3 = p;
    }

    public string getD4()
    {
        return d4;
    }

    public void setD4(string p)
    {
        d4 = p;
    }

    public string getD5()
    {
        return d5;
    }

    public void setD5(string p)
    {
        d5 = p;
    }


    public string getD6()
    {
        return d6;
    }

    public void setD6(string p)
    {
        d6 = p;
    }

    public int Pnum()
    {
        return pnum;
    }

    public void setPnum(int n)
    {
        pnum = n;
    }

    public int getCurrP()
    {
        return currP;
    }

    public void setCurrP(int n)
    {
        currP = n;
    }

    public int getDV1()
    {
        return dfv1;
    }

    public void setDV1(int p)
    {
        dfv1 = p;
    }

    public int getDV2()
    {
        return dfv2;
    }

    public void setDV2(int p)
    {
        dfv2 = p;
    }

    public int getDV3()
    {
        return dfv3;
    }

    public void setDV3(int p)
    {
        dfv3 = p;
    }

    public int getDV4()
    {
        return dfv4;
    }

    public void setDV4(int p)
    {
        dfv4 = p;
    }

    public int getDV5()
    {
        return dfv5;
    }

    public void setDV5(int p)
    {
        dfv5 = p;
    }


    public int getDV6()
    {
        return dfv6;
    }

    public void setDV6(int p)
    {
        dfv6 = p;
    }

}
